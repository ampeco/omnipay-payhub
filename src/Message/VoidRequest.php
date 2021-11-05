<?php

namespace Ampeco\OmnipayPayhub\Message;

class VoidRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $this->validate('transactionId');

        return "pga/transactions/{$this->getTransactionId()}/refund";
    }

    public function getData()
    {
        $this->validate('amount');

        return [
            'amount' => $this->getAmountInteger(),
        ];
    }
}
