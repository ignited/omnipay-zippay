<?php

namespace Omnipay\ZipPay;

use Omnipay\Common\AbstractGateway;

/**
 * ZipPay Gateway
 */
class ZipPayGateway extends AbstractGateway
{
    public function getName()
    {
        return 'ZipPay';
    }

    public function getDefaultParameters()
    {
        return array(
            'key' => '',
            'testMode' => true, //TODO should this be here?
        );
    }

    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }

    /**
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\ZipPay\Message\AuthorizeRequest', $parameters);
    }
}
