<?php

namespace Ampeco\OmnipayPayhub\Message;

class CaptureRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'Postauth';
    }

    public function getData()
    {
        $this->validate('transactionId', 'amount', 'currency');

        return [
            "orderId" => $this->getTransactionId(),
            "totalAmount" => $this->getAmount(),
            "currency" => $this->getCurrency(),
            "paymentInstrument"=> "StoredCard",
        ];
    }
}
