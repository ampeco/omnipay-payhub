<?php

namespace Ampeco\OmnipayPayhub\Message;

class DeleteCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'DeleteCard';
    }

    public function getData()
    {
        $this->validate('email', 'customerId', 'token');

        return [
            "email" => $this->getEmail(),
            "customerId" => $this->getCustomerId(),
            "cardToken" => $this->getToken(),
        ];
    }
}
