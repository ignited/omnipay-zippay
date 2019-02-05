<?php
namespace Omnipay\ZipPay\Message;

class RestCaptureRequest extends AbstractRequest
{
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/charges/' . $this->getChargeId() . '/capture';
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

    public function getIsPartialCapture()
    {
        return $this->getParameter('is_partial_capture');
    }

    public function setIsPartialCapture($value)
    {
        return $this->setParameter('is_partial_capture', $value);
    }

    public function getData()
    {
        $this->validate('chargeId', 'amount', 'is_partial_capture');

        $data = $this->getBaseData();

        $data['amount'] = $this->getAmount();
        $data['is_partial_capture'] = $this->getIsPartialCapture();

        return $data;
    }

    protected function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new RestCaptureResponse($this, $data, $headers, $status);
    }
}
