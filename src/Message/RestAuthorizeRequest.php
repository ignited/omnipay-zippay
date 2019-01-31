<?php
namespace Omnipay\ZipPay\Message;

use Omnipay\ZipPay\Message\RestAuthorizeResponse;

/**
 * Authorize Request
 *
 * @method Response send()
 */
class RestAuthorizeRequest extends AbstractRequest
{
    public function getFirstName()
    {
        return $this->getCard()->getFirstName();
    }

    public function setFirstName($value)
    {
        return $this->getCard()->setFirstName($value);
    }

    public function getLastName()
    {
        return $this->getCard()->getLastName();
    }

    public function setLastName($value)
    {
        return $this->getCard()->setLastName($value);
    }

    public function getEmail()
    {
        return $this->getCard()->getEmail();
    }

    public function setEmail($value)
    {
        return $this->getCard()->setEmail($value);
    }

    public function getReference()
    {
        return $this->getParameter('reference');
    }

    public function setReference($value)
    {
        return $this->setParameter('reference', $value);
    }

    public function getData()
    {
        $this->validate(
            'amount',
            'returnUrl'
        );

        //TODO validate billing address, order, order.items

        $data = $this->getBaseData();

        $data['shopper']['first_name'] = $this->getFirstName();
        $data['shopper']['last_name'] = $this->getLastName();
        $data['shopper']['email'] = $this->getEmail();
        $data['shopper']['billing_address'] = $this->getBillingAddress();
        $data['order'] = $this->getOrder();
        $data['config'] = $this->getConfig();
        $data['metadata'] = $this->getMetaData();

        return $data;
    }

    public function getBillingAddress()
    {
        return [
            'line1' => $this->getBillingAddressLine1(),
            'city' => $this->getBillingAddressCity(),
            'state' => $this->getBillingAddressState(),
            'postal_code' => $this->getBillingAddressPostalCode(),
            'country' => $this->getBillingAddressCountry(),
            'first_name' => $this->getBillingAddressFirstName(),
            'last_name' => $this->getBillingAddressLastName(),
        ];
    }

    public function getOrder()
    {
        return [
            'reference' => $this->getReference(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'shipping' => $this->getOrderShippingDetails(),
            'items' => $this->getOrderItems(),
        ];
    }

    public function getOrderItems()
    {
        return [];
    }

    public function getOrderShippingDetails()
    {
        return [
            'pickup' => true,
        ];
    }

    public function getConfig()
    {
        return [
            'redirect_uri' => $this->getReturnUrl(),
        ];
    }

    public function getMetaData()
    {
        return [];
    }

    public function getBillingAddressLine1()
    {
        return $this->getCard()->getBillingAddress1();
    }

    public function getBillingAddressCity()
    {
        return $this->getCard()->getBillingCity();
    }

    public function getBillingAddressState()
    {
        return $this->getCard()->getBillingState();
    }

    public function getBillingAddressPostalCode()
    {
        return $this->getBillingAddressPostalCode();
    }

    public function getBillingAddressCountry()
    {
        return $this->getCard()->getBillingCountry();
    }

    public function getBillingAddressFirstName()
    {
        return $this->getCard()->getBillingFirstName();
    }

    public function getBillingAddressLastName()
    {
        return $this->getCard()->getBillingLastName();
    }

    protected function createResponse($data)
    {
        return $this->response = new RestAuthorizeResponse($this, $data);
    }
}
