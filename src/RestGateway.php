<?php

namespace Omnipay\ZipPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\ZipPay\Message\RestAuthorizeRequest;
use Omnipay\ZipPay\Message\RestCancelRequest;
use Omnipay\ZipPay\Message\RestCaptureRequest;
use Omnipay\ZipPay\Message\RestCompleteAuthorizeRequest;
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
        return [
            'apiKey' => '',
            'key' => '',
            'testMode' => true,
        ];
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param $value
     * @return string
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->getParameter('key');
    }

    /**
     * @param $value
     * @return string
     */
    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }

    /**
     * @param $value
     * @return string
     */
    public function setSSLCertificatePath($value)
    {
        return $this->setParameter('sslCertificatePath', $value);
    }

    /**
     * @return string
     */
    public function getSSLCertificatePath()
    {
        return $this->getParameter('sslCertificatePath');
    }

    /**
     * @return Message\RestAuthorizeRequest
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest(RestAuthorizeRequest::class, $parameters);
    }

    /**
     * @param array $options
     * @return RestCompleteAuthorizeRequest
     */
    public function completeAuthorize(array $options = [])
    {
        return $this->createRequest(RestCompleteAuthorizeRequest::class, $options);
    }

    /**
     * @param array $options
     * @return RestCaptureRequest
     */
    public function capture(array $options = [])
    {
        return $this->createRequest(RestCaptureRequest::class, $options);
    }

    /**
     * @param array $options
     * @return RestCancelRequest
     */
    public function void(array $options = [])
    {
        return $this->createRequest(RestCancelRequest::class, $options);
    }

    /**
     * @param array $options
     * @return RestRefundRequest
     */
    public function refund(array $options = [])
    {
        return $this->createRequest(RestRefundRequest::class, $options);
    }
}
