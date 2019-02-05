<?php

namespace Omnipay\ZipPay;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\ZipPay\Message\RestAuthorizeResponse;
use Omnipay\ZipPay\Message\RestCompleteAuthorizeResponse;

class RestGatewayTest extends GatewayTestCase
{
    /** @var RestGateway */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new RestGateway($this->getHttpClient(), $this->getHttpRequest());
    }

    protected function getReturnUrl()
    {
        return 'https://my.sandbox.zipmoney.com.au/?co=co_6EwaifOfG4IYHPNhpzQGu2&m=687118c9-d055-4a2e-9922-002f42a50dfc';
    }

    protected function getCheckoutId()
    {
        return 'co_6EwaifOfG4IYHPNhpzQGu2';
    }

    protected function getCurrency()
    {
        return 'AUD';
    }

    protected function getAmount()
    {
        return '200.00';
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('RestAuthorizeResponse.txt');

        $response = $this->gateway->authorize($this->getOptionsForAuthorize())->send();

        $this->assertInstanceOf(RestAuthorizeResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals($this->getReturnUrl(), $response->getRedirectUrl());
    }

    //TODO test any failure cases for authorize

    public function testCompleteAuthorizeSuccess()
    {
        $this->setMockHttpResponse('RestCompleteAuthorizeResponse.txt');

        $response = $this->gateway->completeAuthorize($this->getOptionsForCompleteAuthorize())->send();

        $this->assertInstanceOf(RestCompleteAuthorizeResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
    }

    //TODO test any failure cases for completeAuthorize

    public function testCaptureSuccess()
    {
        //TODO
    }

    //TODO test any failure cases for capture

    public function testCancelSuccess()
    {
        //TODO
    }

    //TODO test any failure cases for cancel

    public function testRefundSuccess()
    {
        //TODO
    }

    //TODO test any failure cases for refund

    private function getOptionsForAuthorize()
    {
        return [
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'card' => $this->getValidCard(),
            'returnUrl' => $this->getReturnUrl(),
        ];
    }

    private function getOptionsForCompleteAuthorize()
    {
        return [
            'amount' => $this->getAmount(),
            'authorityType' => 'checkout_id',
            'authorityValue' => $this->getCheckoutId(),
            'captureFunds' => false,
            'currency' => $this->getCurrency(),
        ];
    }
}
