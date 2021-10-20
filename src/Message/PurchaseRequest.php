<?php

namespace Ampeco\OmnipayPayhub\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'pga/transactions';
    }

    public function getData()
    {
        $this->validate('transactionId', 'customerId', 'amount', 'token', 'description');

        info('AMOUNT', ['amount' => $this->getAmount()]);

        return [
            "amount" => $this->getAmount() * 100,
            "external_id" => $this->getTransactionId(), // "7ef38378-951f-4139-8119-3f270d91fc1b",
            "description" => $this->getDescription(),
            "short_description" => $this->getDescription(),
            "client_ip" => "77.70.127.37",
            "merchant_config_id" => $this->getMerchantConfigId(),
            "payer" => [
                "source" => "WALLET",
                "value" => $this->getToken(),
                "client_id" => $this->getCustomerId(),
                "expire" => "0123",
                "cvv" => "107"
            ],

            // "orderId" => $this->getTransactionId(),
            // "totalAmount" => $this->getAmount(),
            // "currency" => $this->getCurrency(),
            // "customerInfo" => [
            //     "email" => $this->getEmail(),
            //     "customerId" => $this->getCustomerId(),
            // ],
            // "paymentInstrument"=> "StoredCard",
            // "paymentInstrumentInfo" => [
            //     "storedCard" => [
            //         "processType" => $this->getProcessType(),
            //         "cardToken" => $this->getToken(),
            //         "use3DSecure" => false,
            //         // "posAccount" => [
            //         //     "id" => $this->getPosId(),
            //         // ],
            //     ]
            // ],
            // "basketItems"=> [
            //     [
            //         "name" => $this->getDescription(),
            //     ]
            // ]
        ];
    }
}
