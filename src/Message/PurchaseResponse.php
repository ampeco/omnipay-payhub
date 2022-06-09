<?php

namespace Ampeco\OmnipayPayhub\Message;

use Ampeco\OmnipayPayhub\Gateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\ResponseInterface;

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
        $response = $this->getGateway()->getTransaction([
            'transactionId' => $this->getTransactionReference(),
        ])->send();

        $this->tryToLog($response);

        return $response;
    }

    private function getGateway(): Gateway
    {
        return $this->getRequest()->getGateway();
    }

    private function tryToLog(ResponseInterface $response)
    {
        if (function_exists('info')) {
            $request = $response->getRequest();
            $parsedClass = explode('\\', get_class($request));
            $method = array_pop($parsedClass);
            $responseStatus = $response->isSuccessful() ? 'Success' : ($response->isCancelled() ? 'Canceled' : 'Failure');

            info("Payhub: Call {$method} => {$responseStatus}", [
                'payment_processor' => 'Payhub',
                'request' => $request->getData(),
                'response' => $response->getData(),
                'method' => get_class($request),
            ]);
        }
    }
}
