<?php

namespace Ampeco\OmnipayPayhub\Message;

class CreateCardResponse extends Response
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_USED = 'USED';

    public function isSuccessful()
    {
        return parent::isSuccessful()
            && $this->statusIs(self::STATUS_ACTIVE, self::STATUS_USED)
            && in_array($this->data['transaction']['status'], [TransactionResponse::STATUS_PROCESSED]);
    }

    public function getTransactionReference()
    {
        return $this->data['id'];
    }

    public function token()
    {
        return $this->data['transaction']['transaction_id'];
    }

    public function maskedCardNumber()
    {
        return $this->data['transaction']['card_from_hash'];
    }

    public function cardType()
    {
        return $this->data['transaction']['payment_system'];
    }
}
