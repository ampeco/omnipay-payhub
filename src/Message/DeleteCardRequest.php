<?php

namespace Ampeco\OmnipayPayhub\Message;

class DeleteCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'cards';
    }

    public function getHttpMethod()
    {
        return 'DELETE';
    }

    public function getData()
    {
        $this->validate( 'token');

        return [
            "token" => $this->getToken(),
        ];
    }
}
