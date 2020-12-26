<?php

namespace App\Console\Commands;

use App\Services\PayPalService;
use Illuminate\Console\Command;

class CreatePayPalProduct extends Command
{

    private $payPalService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paypal:plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um produto no Paypal para ser gerênciado';

    /**
     * Create a new command instance.
     *
     * @param PayPalService $payPalService
     */
    public function __construct(PayPalService $payPalService)
    {
        $this->payPalService = $payPalService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $product = $this->payPalService->createProduct([
            'name' => 'Estrátegias de Cartas',
            'description' => 'Assinatura para o acesso a estrátegias de cartas.',
            'type' => 'SERVICE',
            'category' => 'SOFTWARE',
        ]);

        $success = $this->setEnvironmentValue(['PRODUCT_PAYPAL_ID' => $product->id]);
        if ($success) {
            $this->info('Produto adicionado com sucesso! PRODUCT_PAYPAL_ID=' . $product->id);
            return;
        }

        $this->error('Produto não pode ser criado!');
    }

    private function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $str .= "\n";
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }

            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;
    }
}
