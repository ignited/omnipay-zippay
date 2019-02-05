<?php
namespace Omnipay\ZipPay\Message;

class RestRefundRequest extends AbstractRequest
{
    protected function getEndpoint()
    {
        return parent::getEndpoint() . '/refunds';
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

    public function getReason()
    {
        return $this->getParameter('reason');
    }

    public function setReason($value)
    {
        return $this->setParameter('reason', $value);
    }

    public function getData()
    {
        $this->validate('chargeId', 'amount', 'reason');

        $data = $this->getBaseData();

        $data['charge_id'] = $this->getChargeId();
        $data['amount'] = $this->getAmount();
        $data['reason'] = $this->getReason();

        return $data;
    }

    protected function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new RestRefundResponse($this, $data, $headers, $status);
    }
}
