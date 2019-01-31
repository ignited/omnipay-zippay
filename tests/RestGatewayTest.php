<?php

namespace Omnipay\ZipPay;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\ZipPay\Message\RestAuthorizeResponse;

class RestGatewayTest extends GatewayTestCase
{
    /** @var RestGateway */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new RestGateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount' => '10.00',
            'card' => $this->getValidCard(),
            'returnUrl' => $this->getReturnUrl(),
        );
    }

    protected function getReturnUrl()
    {
        return 'https://google.com.au';
    }

    public function testAuthorizeSuccess()
    {
        //TODO $this->setMockHttpResponse('mocked-response.txt');

        $response = $this->gateway->authorize($this->options)->send();

        $this->assertInstanceOf(RestAuthorizeResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals($this->getReturnUrl(), $response->getRedirectUrl());
    }
}
