<?php

namespace Omnipay\ZipPay\Message;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\ZipPay\Message\Response;

/**
 * RestAuthorizeResponse
 */
class RestAuthorizeResponse extends Response implements RedirectResponseInterface
{
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * @return array
     */
    public function getRedirectData()
    {
        return [];
    }
}
