<?php

namespace Ampeco\OmnipayPayhub\Message;

use Ampeco\OmnipayPayhub\Gateway;

class PurchaseRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'ProcessPayment';
    }

    public function getProcessType()
    {
        return $this->getParameter('processType') ?? Gateway::PROCESS_TYPE_SALES;
    }

    public function setProcessType($value)
    {
        if (in_array($value = strtolower($value), Gateway::processTypes())) {
            return $this->setParameter('processType', $value);
        }

        return $this;
    }

    public function getData()
    {
        $this->validate('transactionId', 'amount', 'currency', 'token', 'email', 'customerId', 'posId');

        return [
            "orderId" => $this->getTransactionId(),
            "totalAmount" => $this->getAmount(),
            "currency" => $this->getCurrency(),
            "customerInfo" => [
                "email" => $this->getEmail(),
                "customerId" => $this->getCustomerId(),
            ],
            "paymentInstrument"=> "StoredCard",
            "paymentInstrumentInfo" => [
                "storedCard" => [
                    "processType" => $this->getProcessType(),
                    "cardToken" => $this->getToken(),
                    "use3DSecure" => false,
                    // "posAccount" => [
                    //     "id" => $this->getPosId(),
                    // ],
                ]
            ],
            "basketItems"=> [
                [
                    "name" => $this->getDescription(),
                ]
            ]
        ];
    }
}
