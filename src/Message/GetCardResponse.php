<?php

namespace Ampeco\OmnipayPayhub\Message;

class GetCardResponse extends Response
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_USED = 'USED';

    public function isSuccessful()
    {
        return in_array($this->data['status'], [self::STATUS_ACTIVE, self::STATUS_USED]);
    }

    public function getTransactionReference()
    {
        return $this->data['frame_id'];
    }

    public function token()
    {
        return $this->data['token'];
    }

    public function maskedCardNumber()
    {
        return $this->data['masked_pan'];
    }

    public function lastFour()
    {
        return substr($this->maskedCardNumber(), -4);
    }

    public function cardName()
    {
        return $this->data['card_name'];
    }
}
