<?php

namespace Ampeco\OmnipayPayhub\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'frames/links/cards/tokens';
    }

    public function getData()
    {
        $this->validate('transactionId', 'customerId', 'returnUrl');

        return [
            "client" => [
                "id" => $this->getCustomerId(),
            ],
            "external_id" => $this->getTransactionId(),
            "options" => [
                // "ttl" => 0,
                // "create_short_url" => true,
                "backurl" => [
                    "success" => $this->getReturnUrl(),
                    // "error" => "https://yourapp.test/payment/error",
                    // "cancel" => "https://yourapp.test/payment/cancel"
                ]
            ],
            "lang" => "UK",
            // "title" => "Merchant name",
            // "description" => "Payment description",
            "merchant_config_id" => $this->getMerchantConfigId(),
            "config_id" => $this->getConfigId(),
            // "params" => [
            //     "shop_url" => "https://yourapp.test"
            // ],
            "request_card_name" => true
        ];
    }
}
