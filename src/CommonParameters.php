<?php

namespace Ampeco\OmnipayPayhub;

trait CommonParameters
{
    public function getLogin()
    {
        return $this->getParameter('login');
    }

    public function setLogin($value)
    {
        return $this->setParameter('login', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getClient()
    {
        return $this->getParameter('client');
    }

    public function setClient($value)
    {
        return $this->setParameter('client', $value);
    }

    public function getConfigId()
    {
        return $this->getParameter('configId');
    }

    public function setConfigId($value)
    {
        return $this->setParameter('configId', $value);
    }

    public function getMerchantConfigId()
    {
        return $this->getParameter('merchantConfigId');
    }

    public function setMerchantConfigId($value)
    {
        return $this->setParameter('merchantConfigId', $value);
    }
}
