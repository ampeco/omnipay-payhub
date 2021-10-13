<?php

namespace Ampeco\OmnipayPayhub\Message;

use Ampeco\OmnipayPayhub\CommonParameters;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    use CommonParameters;

    const ENDPOINT_PRODUCTION = 'https://rlyeh.payhub.com.ua/';
    const ENDPOINT_TESTING = 'https://innsmouth.payhub.com.ua/';

    abstract public function getEndpoint();

    public function getBaseUrl()
    {
        return $this->getTestMode() ? self::ENDPOINT_TESTING : self::ENDPOINT_PRODUCTION;
    }

    public function getHeaders(): array
    {
        $headers = [];

        return $headers;
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * {@inheritdoc}
     */
    public function sendData($data)
    {
        $headers = array_merge($this->getHeaders(), [
            'Authorization' => 'Bearer ' . $this->getApiToken(),
            // 'MerchantCode' => $this->getMerchantCode(),
            'Content-Type' => 'application/json',
        ]);

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . ltrim($this->getEndpoint(), '/'),
            $headers,
            json_encode($data),
        );

        return $this->createResponse($httpResponse->getBody()->getContents(), $httpResponse->getHeaders());
    }

    public function getApiToken()
    {
        $response = $this->httpClient->request(
            'POST',
            $this->getBaseUrl() . 'auth/token',
            ['Content-Type' => 'application/json'],
            json_encode([
                "login" => $this->getLogin(),
                "password" => $this->getPassword(),
                "client" => $this->getClient(),
            ]),
        );


        $decodedResponse = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() >= 400) {
            throw new \Exception($decodedResponse['error']['code']);
        }

        return $decodedResponse['data']['access_token'];
    }

    // public function getEmail()
    // {
    //     return $this->getParameter('email');
    // }

    // public function setEmail($value)
    // {
    //     return $this->setParameter('email', $value);
    // }

    public function getCustomerId()
    {
        return (string) $this->getParameter('customerId');
    }

    public function setCustomerId($value)
    {
        return $this->setParameter('customerId', $this->prefix($value));
    }

    // public function setTransactionId($value)
    // {
    //     return $this->setParameter('transactionId', $this->prefix($value));
    // }

    protected function createResponse($data, $headers = [])
    {
        return $this->response = new Response($this, $data, $headers);
    }

    protected function prefix($value)
    {
        if ($this->getTestMode() && !is_null($this->getTransactionPrefix())) {
            return $this->getTransactionPrefix() . $value;
        }

        return $value;
    }
}
