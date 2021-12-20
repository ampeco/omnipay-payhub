<?php

namespace Ampeco\OmnipayPayhub\Message;

class VoidRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $this->validate('transactionReference');

        return "pga/transactions/{$this->getTransactionReference()}/refund";
    }

    public function getData()
    {
        $this->validate('amount');

        return [
            'amount' => $this->getAmountInteger(),
        ];
    }
}
