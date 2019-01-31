<?php

namespace Omnipay\ZipPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\ZipPay\Message\RestAuthorizeRequest;

/**
 * ZipPay Gateway
 */
class RestGateway extends AbstractGateway
{
    public function getName()
    {
        return 'ZipPay Rest';
    }

    public function getDefaultParameters()
    {
        return array(
            'apiKey' => '',
            'key' => '',
            'testMode' => true, //TODO should this be here?
        );
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
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
     * @return Message\RestAuthorizeRequest
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest(RestAuthorizeRequest::class, $parameters);
    }
}
