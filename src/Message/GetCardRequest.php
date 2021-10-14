<?php

namespace Ampeco\OmnipayPayhub\Message;

class GetCardRequest extends AbstractRequest
{
    public function getFrameId()
    {
        return $this->getParameter('frameId');
    }

    public function setFrameId($value)
    {
        return $this->setParameter('frameId', $value);
    }

    public function getEndpoint()
    {
        return 'frames/links/cards/tokens';
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function getData()
    {
        return [];
    }

    public function getHeaders(): array
    {
        $this->validate('frameId');

        return [
            "x-frame-id" => $this->getFrameId(),
        ];
    }

    protected function createResponse($data, $headers = [])
    {
        return $this->response = new GetCardResponse($this, $data, $headers);
    }
}
