<?php

namespace Ampeco\OmnipayPayhub\Message;

interface CreateCardResponseInterface
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_USED = 'USED';

    public function token(): string;
    public function maskedCardNumber(): string;
    public function cardType(): string;
}
