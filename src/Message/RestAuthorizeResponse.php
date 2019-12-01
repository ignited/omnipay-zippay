<?php

namespace Omnipay\ZipPay\Message;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\ZipPay\Message\Response;

/**
 * RestAuthorizeResponse
 */
class RestAuthorizeResponse extends Response implements
    RedirectResponseInterface
{
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        $data = $this->getData();
        return isset($data['uri']);
    }

    public function getRedirectUrl()
    {
        $data = $this->getData();
        return isset($data['uri']) ? $data['uri'] : null;
    }
}
