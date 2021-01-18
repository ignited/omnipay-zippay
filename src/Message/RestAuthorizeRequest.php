<?php
namespace Omnipay\ZipPay\Message;

use Omnipay\ZipPay\ItemInterface;
use Omnipay\ZipPay\ItemTypeInterface;
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

    public function getHasShippingAddress()
    {
        return $this->getParameter('hasShippingAddress');
    }

    public function setHasShippingAddress($value)
    {
        return $this->setParameter('hasShippingAddress', $value);
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
            'amount' => $this->formatCurrency($item->getPrice()),
            'quantity' => $item->getQuantity(),
            'type' => $item instanceof ItemTypeInterface ? $item->getType() : 'sku',
            'reference' => $item->getReference(),
            'image_uri' => $item->getImageUri(),
        ];
    }

    public function getOrderShippingDetails()
    {
        $shippingDetails = [
            'pickup' => true,
        ];
        // Check if a shipping address has supposedly been supplied and, if so, set pickup
        // to `false` and add the address details.
        if ($this->getHasShippingAddress()) {
            $shippingDetails = [
                'pickup' => false,
                'address' => [
                    'line1' => $this->getShippingAddressLine1(),
                    'line2' => $this->getShippingAddressLine2(),
                    'city' => $this->getShippingAddressCity(),
                    'state' => $this->getShippingAddressState(),
                    'postal_code' => $this->getShippingAddressPostalCode(),
                    'country' => $this->getShippingAddressCountry(),
                ],
            ];
        }
        return $shippingDetails;
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

    public function getShippingAddressLine1()
    {
        return $this->getCard()->getShippingAddress1();
    }

    public function getShippingAddressLine2()
    {
        return $this->getCard()->getShippingAddress2();
    }

    public function getShippingAddressCity()
    {
        return $this->getCard()->getShippingCity();
    }

    public function getShippingAddressState()
    {
        return $this->getCard()->getShippingState();
    }

    public function getShippingAddressPostalCode()
    {
        return $this->getCard()->getShippingPostcode();
    }

    public function getShippingAddressCountry()
    {
        return $this->getCard()->getShippingCountry();
    }

    protected function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new RestAuthorizeResponse($this, $data, $headers, $status);
    }
}
