<?php

namespace Ampeco\OmnipayPayhub\Message;

class GetTransactionRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $this->validate('transactionId');

        return "pga/transactions/{$this->getTransactionId()}";
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function getData()
    {
        return [];
    }

    protected function getResponseClass()
    {
        return TransactionResponse::class;
    }
}
