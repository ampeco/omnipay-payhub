<?php

namespace Ampeco\OmnipayPayhub\Message;

use Ampeco\OmnipayPayhub\CommonParameters;
use Ampeco\OmnipayPayhub\Gateway;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    use CommonParameters;

    const ENDPOINT_PRODUCTION = 'https://rlyeh.payhub.com.ua/';
    const ENDPOINT_TESTING = 'https://innsmouth.payhub.com.ua/';

    protected ?Gateway $gateway;

    abstract public function getEndpoint();

    public function setGateway(Gateway $gateway)
    {
        $this->gateway = $gateway;
        return $this;
    }

    public function getGateway()
    {
        return $this->gateway;
    }

    public function getBaseUrl()
    {
        return $this->getTestMode() ? self::ENDPOINT_TESTING : self::ENDPOINT_PRODUCTION;
    }

    public function getHeaders(): array
    {
        return [];
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
            'Content-Type' => 'application/json',
        ]);

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getBaseUrl() . ltrim($this->getEndpoint(), '/'),
            $headers,
            json_encode($data),
        );

        return $this->createResponse(
            $httpResponse->getBody()->getContents(),
            $httpResponse->getStatusCode(),
        );
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

    protected function createResponse($data, $statusCode)
    {
        $responseClass = $this->getResponseClass();

        return $this->response = new $responseClass($this, $data, $statusCode);
    }

    protected function getResponseClass()
    {
        return Response::class;
    }
}
