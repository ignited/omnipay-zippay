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
        return 'https://my.sandbox.zipmoney.com.au/?co=co_6EwaifOfG4IYHPNhpzQGu2&m=687118c9-d055-4a2e-9922-002f42a50dfc';
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('RestAuthorizeResponse.txt');

        $response = $this->gateway->authorize($this->options)->send();

        $this->assertInstanceOf(RestAuthorizeResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals($this->getReturnUrl(), $response->getRedirectUrl());
    }
}
