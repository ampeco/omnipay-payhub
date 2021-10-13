<?php

namespace Ampeco\OmnipayPayhub\Message;

class VoidRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'Cancel';
    }

    public function getData()
    {
        $this->validate('transactionId');

        return [
            "orderId" => $this->getTransactionId(),
            "paymentInstrument"=> "StoredCard",
        ];
    }
}
