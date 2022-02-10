<?php

namespace Ampeco\OmnipayPayhub\Message;

use Ampeco\OmnipayPayhub\Gateway;
use Omnipay\Common\Message\RequestInterface;

class PurchaseResponse extends TransactionResponse
{
    const MAX_ATTEMPTS = 3;

    public static float $sleepCoef = 1;
    protected static int $attempts = 0;

    public function __construct(RequestInterface $request, $data, $statusCode)
    {
        parent::__construct($request, $data, $statusCode);

        $this->retryIfProcessing();
    }

    private function retryIfProcessing()
    {
        if ($this->isProcessing()) {
            $this->retry();
        }
    }

    private function retry()
    {
        if (self::$attempts < self::MAX_ATTEMPTS) {
            sleep(++self::$attempts * self::$sleepCoef);

            $response = $this->getTransaction();

            if ($response->isProcessing()) {
                $this->retry();
            } else {
                $this->data = $response->getData();
                self::$attempts = 0;
            }
        } else {
            $this->revertTransaction();
            self::$attempts = 0;
        }
    }

    private function revertTransaction()
    {
        /** @var Response */
        $response = $this->getGateway()->void([
            'transactionReference' => $this->getTransactionReference(),
            'amount' => $this->request->getData()['amount'],
        ])->send();

        if ($response->statusIs(TransactionResponse::STATUS_REFUNDED)) {
            $response = $this->getTransaction();

            if ($response->statusIs(TransactionResponse::STATUS_REFUNDED)) {
                $this->data = $response->getData();
            }
        }
    }

    private function getTransaction(): TransactionResponse
    {
        return $this->getGateway()->getTransaction([
            'transactionId' => $this->getTransactionReference(),
        ])->send();
    }

    private function getGateway(): Gateway
    {
        return $this->getRequest()->getGateway();
    }
}
