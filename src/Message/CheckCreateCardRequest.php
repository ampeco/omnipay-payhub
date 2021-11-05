<?php

namespace Ampeco\OmnipayPayhub\Message;

class CheckCreateCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $this->validate('transactionId');

        return "frames/links/pga/{$this->getTransactionId()}";
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
        return CreateCardResponse::class;
    }
}
