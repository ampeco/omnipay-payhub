<?php

namespace Ampeco\OmnipayPayhub;

use Ampeco\OmnipayPayhub\Message\AbstractRequest;
use Ampeco\OmnipayPayhub\Message\CaptureRequest;
use Ampeco\OmnipayPayhub\Message\PurchaseRequest;
use Ampeco\OmnipayPayhub\Message\CreateCardRequest;
use Ampeco\OmnipayPayhub\Message\DeleteCardRequest;
use Ampeco\OmnipayPayhub\Message\ListTransactionsRequest;
use Ampeco\OmnipayPayhub\Message\ListCardsRequest;
use Ampeco\OmnipayPayhub\Message\Response;
use Ampeco\OmnipayPayhub\Message\VoidRequest;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;

/**
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = [])
 */
class Gateway extends AbstractGateway
{
    use CommonParameters;

    // const PROCESS_TYPE_PREAUTH = 'preauth';
    // const PROCESS_TYPE_SALES = 'sales';

    // public static function processTypes()
    // {
    //     return [
    //         static::PROCESS_TYPE_PREAUTH,
    //         static::PROCESS_TYPE_SALES,
    //     ];
    // }

    public function getName()
    {
        return 'MobilExpress';
    }

    // public function authorize(array $options = []): RequestInterface
    // {
    //     return $this->createRequest(PurchaseRequest::class, array_merge($options, [
    //         'processType' => static::PROCESS_TYPE_PREAUTH,
    //     ]));
    // }

    // public function capture(array $options = []): RequestInterface
    // {
    //     return $this->createRequest(CaptureRequest::class, $options);
    // }

    // public function void(array $options = []): RequestInterface
    // {
    //     return $this->createRequest(VoidRequest::class, $options);
    // }

    // public function purchase(array $options = []): RequestInterface
    // {
    //     return $this->createRequest(PurchaseRequest::class, array_merge($options, [
    //         'processType' => static::PROCESS_TYPE_SALES,
    //     ]));
    // }

    public function createCard(array $options = []): RequestInterface
    {
        return $this->createRequest(CreateCardRequest::class, $options);
    }

     public function deleteCard(array $options = []): RequestInterface
     {
         return $this->createRequest(DeleteCardRequest::class, $options);
     }

    // public function listCards(array $options = []): RequestInterface
    // {
    //     return $this->createRequest(ListCardsRequest::class, $options);
    // }

    // public function listTransactions(array $options = []): RequestInterface
    // {
    //     return $this->createRequest(ListTransactionsRequest::class, $options);
    // }

    // public function acceptNotification()
    // {
    //     $request = $this->getDefaultHttpRequest();

    //     INFO("ACCEPT", [
    //         'content' => $request->getContent(),
    //         'request' => $request->request->all(),
    //         'method' => $request->getMethod(),
    //         'headers' => $request->headers->all(),
    //     ]);

    //     return new Response(
    //         $this->createRequest(CreateCardRequest::class, []),
    //         json_encode($request->request->all()),
    //         $request->headers->all()
    //     );

    //     return $request->getContent(true);

    //     // $client = $this->getClient();
    //     // if ($client->validateCallbackWithGlobals()){
    //     //     $requestBody = file_get_contents('php://input');
    //     //     $res = $client->readCallback($requestBody);
    //     //     return new AcceptNotification($res);
    //     // }
    //     // return new AcceptNotification();
    // }
}
