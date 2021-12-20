<?php

namespace Ampeco\OmnipayPayhub\Message;

class CreateCardResponse extends Response implements CreateCardResponseInterface
{
    public function isSuccessful()
    {
        return parent::isSuccessful()
            && $this->statusIs(static::STATUS_ACTIVE, static::STATUS_USED)
            && in_array($this->data['transaction']['status'], [TransactionResponse::STATUS_PROCESSED]);
    }

    public function token(): ?string
    {
        return $this->data['transaction']['transaction_id'];
    }

    public function maskedCardNumber(): ?string
    {
        return $this->data['transaction']['card_from_hash'];
    }

    public function cardType(): ?string
    {
        return $this->data['transaction']['payment_system'];
    }
}
