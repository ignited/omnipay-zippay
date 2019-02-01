<?php
namespace Omnipay\ZipPay;

use Omnipay\Common\ItemInterface as BaseItemInterface;

interface ItemInterface extends BaseItemInterface
{
    public function getReference();

    public function getImageUri();
}
