<?php

namespace Ampeco\OmnipayPayhub\Message;

class ListTransactionsResponse extends Response
{
    public function getTransactions()
    {
        return $this->data['transactionList'] ?? [];
    }
}
