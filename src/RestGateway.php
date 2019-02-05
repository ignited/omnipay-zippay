<?php

namespace Omnipay\ZipPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\ZipPay\Message\RestAuthorizeRequest;
use Omnipay\ZipPay\Message\RestCompleteAuthorizeRequest;
use Omnipay\ZipPay\Message\RestCaptureRequest;
use Omnipay\ZipPay\Message\RestCancelRequest;
use Omnipay\ZipPay\Message\RestRefundRequest;

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
            'testMode' => true,
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

    public function completeAuthorize(array $options = array())
    {
        return $this->createRequest(RestCompleteAuthorizeRequest::class, $options);
    }

    public function capture(array $options = array())
    {
        return $this->createRequest(RestCaptureRequest::class, $options);
    }

    public function void(array $options = array())
    {
        return $this->createRequest(RestCancelRequest::class, $options);
    }

    public function refund(array $options = array())
    {
        return $this->createRequest(RestRefundRequest::class, $options);
    }
}
