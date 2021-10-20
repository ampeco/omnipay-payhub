<?php

namespace Ampeco\OmnipayPayhub\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\ResponseInterface;

class Response extends AbstractResponse implements ResponseInterface, RedirectResponseInterface
{

    /**
     * Request id
     *
     * @var string URL
     */
    protected $requestId = null;

    /**
     * @var array
     */
    protected $headers = [];

    protected bool $hasError;

    public function __construct(RequestInterface $request, $data, $headers = [], $hasError = false)
    {
        $this->request = $request;
        $this->data = json_decode($data, true);
        $this->headers = $headers;
        $this->hasError = $hasError;
    }

    public function isSuccessful()
    {
        return ! $this->hasError;
    }

    public function isRedirect()
    {
        return !is_null($this->getRedirectUrl());
    }

    public function getRedirectUrl()
    {
        return isset($this->data['url']) ? $this->data['url'] : null;
    }

    public function getTransactionReference()
    {
        if (! $this->isSuccessful()) {
            return null;
        }

        return $this->data['id'];
    }
}
