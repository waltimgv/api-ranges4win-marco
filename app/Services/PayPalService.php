<?php

namespace App\Services;

use App\Enums\PayPalPaymentStatus;
use App\Exceptions\PayPalServiceException;
use App\PayPalPlan;
use App\Plan;
use App\PlanUser;
use App\User;
use Illuminate\Support\Facades\Date;
use PayPal\Api\VerifyWebhookSignature;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalService
{

    private $oAuth;
    private $auth;
    private $api;
    private $context;

    public function __construct()
    {
        if (config('paypal.mode') === 'sandbox') {
            $this->auth = new SandboxEnvironment(config('paypal.client_id'), config('paypal.secret'));
        } else {
            $this->auth = new ProductionEnvironment(config('paypal.client_id'), config('paypal.secret'));
        }

        $this->oAuth = new OAuthTokenCredential(config('paypal.client_id'), config('paypal.secret'));

        $this->api = new PayPalHttpClient($this->auth);
        $this->context = new ApiContext($this->oAuth);
        $this->context->setConfig([
            'mode' => config('paypal.mode'),
            'log.LogEnabled' => true,
            'log.FileName' => storage_path('logs/PayPal.log'),
            'log.LogLevel' => 'FINE',
            'cache.enabled' => true,
            'cache.FileName' => storage_path('logs/Paypal.auth.cache'),
            'validation.level' => 'log'
        ]);
    }

    public function getSubscription($id)
    {
        $subscription = (new PayPalPlan)->executeGet("/v1/payments/billing-agreements/$id", $this->context);
        if ($subscription && (strtoupper($subscription->state) === PayPalPaymentStatus::ACTIVE)) {
            return $subscription;
        }

        throw new \Exception('Transação não autorizada');
    }

    public function cancelSubscription($id)
    {
        $note = [
            "note" => "Assinatura cancelada pelo sistema.",
        ];

        return (new PayPalPlan)->executePost("/v1/payments/billing-agreements/$id/cancel", $note, $this->context);
    }

    /**
     * Seleciona o plano e envia os dados para o Paypal.
     *
     * @param Plan $plan
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws PayPalServiceException
     */
    public function chargePlanToUser(Plan $plan, User $user, $subscription)
    {
        $expireAt = (strtoupper($subscription->state) === PayPalPaymentStatus::ACTIVE) ? PlanUser::calculeExpireTime($plan->number_days) : null;

        return PlanUser::query()->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'transaction_id' => $subscription->id,
            'transaction_status' => strtoupper($subscription->state),
            'transaction_payer' => $subscription->payer['payer_info']['payer_id'],
            'paid_at' => Date::now(),
            'expire_at' => $expireAt,
            'price_paid' => $plan->discount_price,
        ]);
    }

    public function createPlan(array $attributes)
    {
        try {
            $plan = (new Plan)->fill($attributes);

            $paypalPlan = $this->newPaypalPlanInstance($plan);

            $plan->paypal_id = $paypalPlan->id;

            return $plan;
        } catch (\PayPal\Exception\PayPalConnectionException $e) {
            echo $e->getData();
            die;
        }
    }

    public function updatePlan(Plan $plan, array $attributes)
    {
        $planPaypal = $this->createPlan($attributes)->toArray();
        return $plan->fill($planPaypal);
    }

    public function deletePlan(Plan $plan)
    {
        $paypalPlan = PayPalPlan::get($plan->paypal_id, $this->context);
        $paypalPlan->delete($this->context);

        return $plan;
    }

    private function newPaypalPlanInstance(Plan $plan)
    {
        $currency = $this->getCurrencyForPlan($plan);

        $plan = [
            'product_id' => config('paypal.product_id'),
            'name' => "Plano de $plan->number_days dias",
            'status' => 'ACTIVE',
            'description' => $plan->description,
            'billing_cycles' => [
                [
                    'frequency' => [
                        'interval_unit' => 'DAY',
                        'interval_count' => $plan->number_days
                    ],
                    'tenure_type' => 'REGULAR',
                    'sequence' => '1',
                    'total_cycles' => '0',
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => $plan->discount_price,
                            'currency_code' => $currency
                        ]
                    ]
                ]
            ],
            'payment_preferences' => [
                'service_type' => 'PREPAID',
                'auto_bill_outstanding' => true,
                'payment_failure_threshold' => 3
            ],
            'quantity_supported' => true,
        ];

        return (new PayPalPlan)->executePost('/v1/billing/plans', $plan, $this->context);
    }

    public function createProduct($attributes)
    {
        return (new PayPalPlan)->executePost('/v1/catalogs/products', $attributes, $this->context);
    }

    public function verifyWebhook($id, $resquestJsonBody, $requestHeader)
    {
        $headers = array_change_key_case($requestHeader, CASE_UPPER);

        $signatureVerification = new VerifyWebhookSignature();
        $signatureVerification->setAuthAlgo($headers['PAYPAL-AUTH-ALGO']);
        $signatureVerification->setTransmissionId($headers['PAYPAL-TRANSMISSION-ID']);
        $signatureVerification->setCertUrl($headers['PAYPAL-CERT-URL']);
        $signatureVerification->setWebhookId($id);
        $signatureVerification->setTransmissionSig($headers['PAYPAL-TRANSMISSION-SIG']);
        $signatureVerification->setTransmissionTime($headers['PAYPAL-TRANSMISSION-TIME']);

        $signatureVerification->setRequestBody($resquestJsonBody);
        return $signatureVerification->post($this->context);
    }

    public function getCurrencyForPlan(Plan $plan = null): string
    {
        $paypalCurrency = config('paypal.currency') ?? "USD";
        return $plan->currency ?? $paypalCurrency;
    }

}