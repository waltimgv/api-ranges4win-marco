<?php

namespace App\Http\Controllers;

use App\Enums\PaypalWebhookEventType;
use App\Http\Requests\Paypal\CancelRequest;
use App\Http\Requests\Paypal\PurchaseRequest;
use App\Plan;
use App\PlanUser;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaypalController extends Controller
{

    private $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }

    public function purchase(PurchaseRequest $request)
    {
        try {
            $plan = Plan::query()->find($request->plan['id']);
            $subscription = $this->paypalService->getSubscription($request->transaction['id']);

            $planUser = $this->paypalService->chargePlanToUser($plan, auth()->user(), $subscription);
            return response()->json($planUser);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function cancel(CancelRequest $request)
    {
        try {
            $this->paypalService->cancelSubscription(auth()->user()->last_plan->transaction_id);
            auth()->user()->last_plan->setTransactionCanceled();

            return response()->json(auth()->user()->last_plan);
        } catch (\Exception $e) {
            return response()->json('Cancelamento do plano não processado', 500);
        }
    }

    public function webhook(Request $request)
    {
        try {
            $this->paypalService->verifyWebhook($request->get('id'), $request->json(), $request->headers);

            $planUser = PlanUser::query()->where('transaction_id', $request->get('resource')['id'])->first();
            $event = $request->get('event_type');

            if (PaypalWebhookEventType::hasValue($event)) {
                switch ($event) {
                    case PaypalWebhookEventType::RENEWED:
                        $planUser->setTransactionRenewed();
                        break;

                    case PaypalWebhookEventType::EXPIRED:
                        $planUser->setTransactionExpired();
                        break;

                    case PaypalWebhookEventType::SUSPENDED:
                        $planUser->setTransactionSuspended();
                        break;

                    case PaypalWebhookEventType::FAILED:
                        $planUser->setTransactionPaymentFailed();
                        break;

                    case PaypalWebhookEventType::CANCELLED:
                        $planUser->setTransactionCanceled();
                        break;
                }

                return response()->json([], 200);
            }

            return response()->json('Evento não utilizado pela aplicação', 401);
        } catch (\Exception $e) {
            return response()->json('Operação não processada', 500);
        }
    }

}