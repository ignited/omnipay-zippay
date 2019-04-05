<?php

namespace Omnipay\ZipPay\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Omnipay\ZipPay\Helper\Uuid;

/**
 * Abstract Request
 *
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    /**
     * @var string
     */
    protected $liveEndpoint = 'https://api.zipmoney.com.au/merchant/v1';
    /**
     * @var string
     */
    protected $testEndpoint = 'https://api.sandbox.zipmoney.com.au/merchant/v1';

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
     * Get Idempotency Key
     * @return string Idempotency Key
     */
    public function getIdempotencyKey()
    {
        return $this->getParameter('idempotencyKey') ?: Uuid::create();
    }

    /**
     * Set Idempotency Key
     * @param  string $value Idempotency Key
     */
    public function setIdempotencyKey($value)
    {
        return $this->setParameter('idempotencyKey', $value);
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
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiKey(),
            'Zip-Version' => '2017-03-01',
            'Idempotency-Key' => $this->getIdempotencyKey(),
        ];
    }

    /**
     * @param $data
     * @return Response
     */
    public function sendData($data)
    {
        if ($this->getSSLCertificatePath()) {
            $this->httpClient->setSslVerification($this->getSSLCertificatePath());
        }

        $endPoint = $this->getEndpoint();

        if ($this->getHttpMethod() === 'GET') {
            $endPoint = $endPoint . '?' . http_build_query($data, '', '&');
        }

        $response = $this->httpClient->createRequest(
            $this->getHttpMethod(),
            $endPoint,
            $this->getHeaders(),
            json_encode($data)
        )->send();

        return $this->createResponse($response->json(), $response->getHeaders(), $response->getStatusCode());
    }

    public function getHttpMethod()
    {
        return 'GET';
    }

    protected function getBaseData()
    {
        return [];
    }

    /**
     * @return string
     */
    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * @param $data
     * @param array $headers
     * @param $status
     * @return Response
     */
    protected function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new Response($this, $data, $headers);
    }
}
