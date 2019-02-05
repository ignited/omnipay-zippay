<?php
namespace Omnipay\ZipPay\Message;

class RestCancelRequest extends AbstractRequest
{
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/charges/' . $this->getChargeId() . '/cancel';
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

    public function getChargeId()
    {
        return $this->getParameter('chargeId');
    }

    public function setChargeId($value)
    {
        return $this->setParameter('chargeId', $value);
    }

    public function getData()
    {
        $this->validate('chargeId');

        return $this->getBaseData();
    }

    protected function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new RestCancelResponse($this, $data, $headers, $status);
    }
}
