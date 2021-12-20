<?php

namespace Ampeco\OmnipayPayhub\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getLang()
    {
        return $this->getParameter('lang');
    }

    public function setLang($value)
    {
        $value = strtoupper($value);
        if (! in_array($value, ['EN', 'UK', 'RU'])) {
            $value = 'EN';
        }

        return $this->setParameter('lang', $value);
    }

    public function getEndpoint()
    {
        if ($this->is2DS()) {
            return 'frames/links/cards/tokens';
        } else {
            return 'frames/links/pga';
        }
    }

    public function getData()
    {
        $this->validate('transactionId', 'returnUrl', 'lang', 'description');

        $params = [
            "external_id" => $this->getTransactionId(),
            "options" => [
                "ttl" => 0,
                "backurl" => [
                    "success" => $this->getReturnUrl(),
                    "error" => $this->getReturnUrl(),
                    "cancel" => $this->getReturnUrl(),
                ],
            ],
            "lang" => $this->getLang(),
            // "title" => "Merchant name",
            "description" => $this->getDescription(),
            "short_description" => $this->getDescription(),
            "merchant_config_id" => $this->getMerchantConfigId(),
            "config_id" => $this->getConfigId(),
            "request_card_name" => false,
        ];

        if ($this->is2DS()) {
            $params['client'] = [
                'id' => $this->getUserId(),
            ];
        } else {
            $params['amount'] = $this->getGateway()->getCreateCardAmount() * 100;
        }

        return $params;
    }
}
