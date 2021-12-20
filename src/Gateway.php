<?php

namespace Ampeco\OmnipayPayhub;

use Ampeco\OmnipayPayhub\Message\AbstractRequest;
use Ampeco\OmnipayPayhub\Message\CaptureRequest;
use Ampeco\OmnipayPayhub\Message\CheckCreateCardRequest;
use Ampeco\OmnipayPayhub\Message\PurchaseRequest;
use Ampeco\OmnipayPayhub\Message\CreateCardRequest;
use Ampeco\OmnipayPayhub\Message\DeleteCardRequest;
use Ampeco\OmnipayPayhub\Message\GetTransactionRequest;
use Ampeco\OmnipayPayhub\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;

/**
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = [])
 * @method \Omnipay\Common\Message\AbstractRequest completeAuthorize(array $options = [])
 * @method \Omnipay\Common\Message\AbstractRequest completePurchase(array $options = [])
 * @method \Omnipay\Common\Message\AbstractRequest refund(array $options = [])
 * @method \Omnipay\Common\Message\AbstractRequest fetchTransaction(array $options = [])
 * @method \Omnipay\Common\Message\AbstractRequest updateCard(array $options = [])
 */
class Gateway extends AbstractGateway
{
    use CommonParameters;

    const VERSION_3DS = '3DS';
    const VERSION_2DS = '2DS';

    public function getName()
    {
        return 'Payhub';
    }

    public function getCreateCardAmount()
    {
        return 1;
    }

    public function getCreateCardCurrency()
    {
        return 'UAH';
    }

    public function authorize(array $options = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, array_merge($options, ['hold' => true]));
    }

    public function capture(array $options = []): AbstractRequest
    {
        return $this->createRequest(CaptureRequest::class, $options);
    }

    public function void(array $options = []): AbstractRequest
    {
        return $this->createRequest(VoidRequest::class, $options);
    }

    public function purchase(array $options = []): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, array_merge($options, ['hold' => false]));
    }

    public function createCard(array $options = []): AbstractRequest
    {
        return $this->createRequest(CreateCardRequest::class, $options);
    }

     public function deleteCard(array $options = []): AbstractRequest
     {
         return $this->createRequest(DeleteCardRequest::class, $options);
     }

    public function getTransaction(array $options = []): AbstractRequest
    {
        return $this->createRequest(GetTransactionRequest::class, $options);
    }

    public function checkCreateCard(array $options = []): AbstractRequest
    {
        return $this->createRequest(CheckCreateCardRequest::class, $options);
    }

    protected function createRequest($class, array $parameters)
    {
        /** @var AbstractRequest */
        $req = parent::createRequest($class, $parameters);
        return $req->setGateway($this);
    }
}
