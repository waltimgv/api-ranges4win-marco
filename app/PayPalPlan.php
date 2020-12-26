<?php

namespace App;

use PayPal\Validation\ArgumentValidator;

class PayPalPlan extends \PayPal\Api\Plan
{

    public function executeGet(string $url, $apiContext = null)
    {
        $json = self::executeCall($url, 'GET', null, null, $apiContext, null);
        return $this->fromJson($json);
    }

    public function executePost(string $url, array $attributes, $apiContext = null)
    {
        $json = self::executeCall($url, 'POST', \GuzzleHttp\json_encode($attributes), null, $apiContext, null);
        return $this->fromJson($json);
    }

    public function create($apiContext = null, $restCall = null)
    {
        $payLoad = $this->toJSON();
        $json = self::executeCall(
            "/v1/billing/plans",
            "POST",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        $this->fromJson($json);
        return $this;
    }

    public function update($patchRequest, $apiContext = null, $restCall = null)
    {
        ArgumentValidator::validate($this->getId(), "Id");
        ArgumentValidator::validate($patchRequest, 'patchRequest');
        $payLoad = $patchRequest->toJSON();
        self::executeCall(
            "/v1/billing/plans/{$this->getId()}",
            "PATCH",
            $payLoad,
            null,
            $apiContext,
            $restCall
        );
        return true;
    }

}
