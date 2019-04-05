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

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->getCard()->getFirstName();
    }

    /**
     * @param $value
     */
    public function setFirstName($value)
    {
        return $this->getCard()->setFirstName($value);
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->getCard()->getLastName();
    }

    /**
     * @param $value
     */
    public function setLastName($value)
    {
        return $this->getCard()->setLastName($value);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->getCard()->getEmail();
    }

    /**
     * @param $value
     */
    public function setEmail($value)
    {
        return $this->getCard()->setEmail($value);
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->getParameter('reference');
    }

    /**
     * @param $value
     */
    public function setReference($value)
    {
        return $this->setParameter('reference', $value);
    }

    /**
     * @return string
     */
    public function getMeta()
    {
        return $this->getParameter('meta');
    }

    /**
     * @param $value
     */
    public function setMeta($value)
    {
        return $this->setParameter('meta', $value);
    }

    public function hasMetaData()
    {
        return !empty($this->getMeta());
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function getOrder()
    {
        $data = [
            'reference' => $this->getReference(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'shipping' => $this->getOrderShippingDetails(),
        ];

        if ($this->getOrderItems()) {
            $data['items'] = $this->getOrderItems();
        }

        return $data;
    }

    /**
     * @return array
     */
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

    /**
     * @param ItemInterface $item
     */
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

    /**
     * @return string
     */
    public function getMetaData()
    {
        return $this->getMeta();
    }

    /**
     * @return string
     */
    public function getBillingAddressLine1()
    {
        return $this->getCard()->getBillingAddress1();
    }

    /**
     * @return string
     */
    public function getBillingAddressCity()
    {
        return $this->getCard()->getBillingCity();
    }

    /**
     * @return string
     */
    public function getBillingAddressState()
    {
        return $this->getCard()->getBillingState();
    }

    /**
     * @return string
     */
    public function getBillingAddressPostalCode()
    {
        return $this->getCard()->getBillingPostcode();
    }

    /**
     * @return string
     */
    public function getBillingAddressCountry()
    {
        return $this->getCard()->getBillingCountry();
    }

    /**
     * @return string
     */
    public function getBillingAddressFirstName()
    {
        return $this->getCard()->getBillingFirstName();
    }

    /**
     * @return string
     */
    public function getBillingAddressLastName()
    {
        return $this->getCard()->getBillingLastName();
    }

    /**
     * @param $data
     * @param array $headers
     * @param $status
     * @return RestAuthorizeResponse
     */
    protected function createResponse($data, $headers = [], $status = 404)
    {
        return $this->response = new RestAuthorizeResponse($this, $data, $headers, $status);
    }
}
