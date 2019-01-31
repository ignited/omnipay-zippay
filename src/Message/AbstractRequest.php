<?php

namespace Omnipay\ZipPay\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Abstract Request
 *
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    protected $liveEndpoint = 'https://api.zipmoney.com.au/merchant/v1';
    protected $testEndpoint = 'https://api.sandbox.zipmoney.com.au/merchant/v1';

    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiKey(),
            'Zip-Version' => '2017-03-01',
        ];
    }

    public function sendData($data)
    {
        $headers = $this->getHeaders();

        $url = $this->getEndpoint().'?'.http_build_query($data, '', '&');
        $response = $this->httpClient->request('GET', $url, $headers);

        $data = json_decode($response->getBody(), true);

        return $this->createResponse($data);
    }

    protected function getBaseData()
    {
        return [];
    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    protected function createResponse($data)
    {
        return $this->response = new Response($this, $data);
    }
}
