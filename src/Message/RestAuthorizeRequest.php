<?php
namespace Omnipay\ZipPay\Message;

use Omnipay\ZipPay\ItemInterface;
use Omnipay\ZipPay\Message\RestAuthorizeResponse;

/**
 * Authorize Request
 *
 * @method Response send()
 */
class RestAuthorizeRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/checkouts';
    }

    public function getHttpMethod()
    {
        return 'POST';
    }

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

    public function getMeta()
    {
        return $this->getParameter('meta');
    }

    public function setMeta($value)
    {
        return $this->setParameter('meta', $value);
    }

    public function hasMetaData()
    {
        return !empty($this->getMeta());
    }

    public function getData()
    {
        $this->validate(
            'amount',
            'currency',
            'returnUrl'
        );

        $data = $this->getBaseData();

        $data['shopper']['first_name'] = $this->getFirstName();
        $data['shopper']['last_name'] = $this->getLastName();
        $data['shopper']['email'] = $this->getEmail();
        $data['shopper']['billing_address'] = $this->getBillingAddress();
        $data['order'] = $this->getOrder();
        $data['config'] = $this->getConfig();

        if ($this->hasMetaData()) {
            $data['metadata'] = $this->getMetaData();
        }

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
        $data = [];
        $items = $this->getItems();

        if ($items) {
            foreach ($items as $item) {
                $data[] = $this->convertItemToItemData($item);
            }
        }

        return $data;
    }

    protected function convertItemToItemData(ItemInterface $item)
    {
        return [
            'name' => $item->getName(),
            'amount' => $item->getQuantity() * $this->formatCurrency($item->getPrice()),
            'quantity' => $item->getQuantity(),
            'type' => 'sku',
            'reference' => $item->getReference(),
            'image_uri' => $item->getImageUri(),
        ];
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
        return $this->getMeta();
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
        return $this->getCard()->getBillingPostcode();
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

    protected function createResponse($data, $headers = [])
    {
        return $this->response = new RestAuthorizeResponse($this, $data, $headers);
    }
}
