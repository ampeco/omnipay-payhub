<?php

namespace Ampeco\OmnipayPayhub\Message;

class TransactionResponse extends Response
{
    const STATUS_PROCESSING = 'PROCESSING';
    const STATUS_PROCESSED = 'PROCESSED';
    const STATUS_HOLDED = 'HOLDED';
    const STATUS_REFUNDED = 'REFUNDED';

    public function isSuccessful()
    {
        return parent::isSuccessful()
            && $this->statusIs(self::STATUS_PROCESSED, self::STATUS_HOLDED);
    }

    public function isProcessing()
    {
        return ! $this->isSuccessful() && $this->statusIs(self::STATUS_PROCESSING);
    }

    public function maskedCardNumber()
    {
        return $this->data['card_from_hash'];
    }
}
