<?php

namespace Ampeco\OmnipayPayhub\Message;

class CaptureRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $this->validate('transactionId');

        return "pga/transactions/{$this->getTransactionId()}/complete_hold";
    }

    public function getData()
    {
        $this->validate('amount');

        return [
            "amount" => $this->getAmount() * 100,
        ];
    }
}
