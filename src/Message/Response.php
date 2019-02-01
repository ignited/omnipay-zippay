<?php

namespace Omnipay\ZipPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Response
 */
class Response extends AbstractResponse
{
    protected $headers;

    public function __construct(RequestInterface $request, $data, $headers)
    {
        $this->request = $request;
        $this->data = $data;
        $this->headers = $headers;
    }

    public function isSuccessful()
    {
        $statusCode = $this->getCode();

        if (is_null($statusCode)) {
            return false;
        }

        return $statusCode >= 200 && $statusCode <= 399;
    }

    public function getCode()
    {
        return $this->getHeader('status');
    }

    public function getTransactionId()
    {
        return $this->getDataField('id');
    }

    public function getTransactionReference()
    {
        return $this->getDataField('order.reference');
    }

    public function isRedirect()
    {
        return !empty($this->getRedirectUrl());
    }

    public function getRedirectUrl()
    {
        return $this->getDataField('uri');
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getMessage()
    {
        return $this->getDataField('state');
    }

    protected function getHeader($field)
    {
        if (empty($this->headers[$field])) {
            return null;
        }

        return reset($this->headers[$field]);
    }

    protected function getDataField($field)
    {
        if (strpos($field, '.') === false) {
            return $this->getTopLevelDataField($field);
        }

        return $this->getNestedDataField($field);
    }

    protected function getTopLevelDataField($field)
    {
        if (isset($this->data[$field])) {
            return $this->data[$field];
        }

        return null;
    }

    protected function getNestedDataField($field)
    {
        $levels = explode('.', $field);
        $data = $this->data;
        foreach ($levels as $level) {
            if (!isset($data[$level])) {
                return null;
            }

            $data = $data[$level];
        }

        return $data;
    }
}
