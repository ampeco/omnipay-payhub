<?php

namespace Ampeco\OmnipayPayhub\Message;

class DeleteCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $this->validate('transactionReference');

        return "frames/links/pga/{$this->getTransactionReference()}/refund";
    }

    public function getHttpMethod()
    {
        return 'PUT';
    }

    public function getData()
    {
        $this->validate('token');

        return [
            "transaction_id" => $this->getToken(),
        ];
    }
}
