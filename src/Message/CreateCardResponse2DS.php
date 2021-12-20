<?php

namespace Ampeco\OmnipayPayhub\Message;

class CreateCardResponse2DS extends Response implements CreateCardResponseInterface
{
    public function isSuccessful(): bool
    {
        return parent::isSuccessful()
            && $this->statusIs(static::STATUS_ACTIVE, static::STATUS_USED);
    }

    public function getTransactionReference(): ?string
    {
        return @$this->data['frame_id'];
    }

    public function token(): ?string
    {
        return @$this->data['token'];
    }

    public function maskedCardNumber(): ?string
    {
        return @$this->data['masked_pan'];
    }

    public function cardType(): ?string
    {
        return @$this->data['card_name'];
    }
}
