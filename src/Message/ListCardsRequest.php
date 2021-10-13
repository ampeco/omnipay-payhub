<?php

namespace Ampeco\OmnipayPayhub\Message;

class ListCardsRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'GetCardList';
    }

    public function getData()
    {
        $this->validate('email', 'customerId');

        return [
            "email" => $this->getEmail(),
            "customerId" => $this->getCustomerId(),
        ];
    }

    protected function createResponse($data, $headers = [])
    {
        return $this->response = new ListCardsResponse($this, $data, $headers);
    }
}
