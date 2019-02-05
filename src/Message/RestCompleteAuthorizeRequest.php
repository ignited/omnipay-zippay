<?php
namespace Omnipay\ZipPay\Message;

use Omnipay\ZipPay\Message\RestCompleteAuthorizeResponse;

class RestCompleteAuthorizeRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/charges';
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getReference()
    {
        return $this->getParameter('reference');
    }

    public function setReference($value)
    {
        return $this->setParameter('reference', $value);
    }

    public function hasReference()
    {
        return !empty($this->getReference());
    }

    public function getAuthorityType()
    {
        return $this->getParameter('authorityType');
    }

    public function setAuthorityType($value)
    {
        return $this->setParameter('authorityType', $value);
    }

    public function getAuthorityValue()
    {
        return $this->getParameter('authorityValue');
    }

    public function setAuthorityValue($value)
    {
        return $this->setParameter('authorityValue', $value);
    }

    public function getCaptureFunds()
    {
        return $this->getParameter('captureFunds');
    }

    public function setCaptureFunds($value)
    {
        return $this->setParameter('captureFunds', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'authorityType', 'authorityValue', 'captureFunds', 'currency');

        $data = $this->getBaseData();

        $data['authority'] = $this->getAuthority();
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['capture'] = $this->getCaptureFunds();

        if ($this->hasReference()) {
            $data['reference'] = $this->getReference();
        }

        return $data;
    }

    public function getAuthority()
    {
        return [
            'type' => $this->getAuthorityType(),
            'value' => $this->getAuthorityValue(),
        ];
    }

    protected function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new RestCompleteAuthorizeResponse($this, $data, $headers, $status);
    }
}
