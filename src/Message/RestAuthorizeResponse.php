<?php

namespace Omnipay\ZipPay\Message;

use Omnipay\ZipPay\Message\Response;

/**
 * RestAuthorizeResponse
 */
class RestAuthorizeResponse extends Response
{
    public function isSuccessful()
    {
        return false;
    }
}
