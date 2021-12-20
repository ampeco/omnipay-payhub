<?php

namespace Ampeco\OmnipayPayhub\Message;

class DeleteCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        if ($this->is2DS()) {
            return "frames/links/cards";
        } else {
            $this->validate('transactionReference');

            return "frames/links/pga/{$this->getTransactionReference()}/refund";
        }
    }

    public function getHttpMethod()
    {
        return $this->is2DS() ? 'DELETE' : 'PUT';
    }

    public function getData()
    {
        $this->validate('token');

        if ($this->is2DS()) {
            return [
                "token" => $this->getToken(),
            ];
        } else {
            return [
                "transaction_id" => $this->getToken(),
            ];
        }
    }
}
