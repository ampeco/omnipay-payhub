<?php

namespace Ampeco\OmnipayPayhub\Message;

class ListTransactionsRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return 'GetTransactionList';
    }

    public function getStartDate()
    {
        return $this->getParameter('startDate');
    }

    public function setStartDate($value)
    {
        return $this->setParameter('startDate', $value);
    }

    public function getData()
    {
        $this->validate('email', 'customerId');

        $params = [
            "customerInfo" => [
                "email" => $this->getEmail(),
                "customerId" => $this->getCustomerId(),
            ],
            "sortDesc" => true,
        ];

        if ($this->getStartDate()) {
            $params["startDate"] = $this->getStartDate()->format('Y-m-d H:i');
        }

        return $params;
    }

    protected function createResponse($data, $headers = [])
    {
        return $this->response = new ListTransactionsResponse($this, $data, $headers);
    }
}
