<?php

namespace Ampeco\OmnipayPayhub\Message;

class CheckCreateCardRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        if ($this->is2DS()) {
            return 'frames/links/cards/tokens';
        } else {
            $this->validate('transactionId');

            return "frames/links/pga/{$this->getTransactionId()}";
        }
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    public function getHeaders(): array
    {
        if ($this->is2DS()) {
            $this->validate('transactionId');

            return [
                'x-frame-id' => $this->getTransactionId(),
            ];
        } else {
            return [];
        }
    }

    public function getData()
    {
        return [];
    }

    protected function getResponseClass()
    {
        if ($this->is2DS()) {
            return CreateCardResponse2DS::class;
        } else {
            return CreateCardResponse::class;
        }
    }
}
