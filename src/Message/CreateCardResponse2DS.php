<?php

namespace Ampeco\OmnipayPayhub\Message;

class CreateCardResponse2DS extends Response implements CreateCardResponseInterface
{
    public function isSuccessful(): bool
    {
        return parent::isSuccessful()
            && $this->statusIs(static::STATUS_ACTIVE, static::STATUS_USED)
            && isset($this->data['token'])
            && !empty($this->data['token'])
            && isset($this->data['masked_pan'])
            && !empty($this->data['masked_pan'])
            && isset($this->data['card_name'])
            && !empty($this->data['card_name']);
    }

    public function getTransactionReference(): ?string
    {
        return @$this->data['frame_id'];
    }

    public function token(): string
    {
        return $this->data['token'];
    }

    public function maskedCardNumber(): string
    {
        return $this->data['masked_pan'];
    }

    public function cardType(): string
    {
        return $this->data['card_name'];
    }
}
