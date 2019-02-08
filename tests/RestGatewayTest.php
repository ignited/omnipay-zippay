<?php

namespace Omnipay\ZipPay;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\ZipPay\Message\RestAuthorizeResponse;
use Omnipay\ZipPay\Message\RestCaptureResponse;
use Omnipay\ZipPay\Message\RestCompleteAuthorizeResponse;
use Omnipay\ZipPay\Message\RestCancelResponse;
use Omnipay\ZipPay\Message\RestRefundResponse;

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

    protected function getChargeId()
    {
        return 'ch_2wOG31hdtqzPlJpBn5zJ24';
    }

    public function testAuthorizeSuccess()
    {
        $this->setMockHttpResponse('RestAuthorizeResponse.txt');

        $response = $this->gateway->authorize($this->getOptionsForAuthorize())->send();

        $this->assertInstanceOf(RestAuthorizeResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals($this->getReturnUrl(), $response->getRedirectUrl());
    }

    public function testAuthorizeFailure()
    {
        $this->setMockHttpResponse('RestAuthorizeFailedResponse.txt');

        $response = $this->gateway->authorize($this->getOptionsForAuthorize())->send();

        $this->assertInstanceOf(RestAuthorizeResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertNotNull($response->getErrorCode());
        $this->assertNotNull($response->getMessage());
    }

    public function testCompleteAuthorizeSuccess()
    {
        $this->setMockHttpResponse('RestCompleteAuthorizeResponse.txt');

        $response = $this->gateway->completeAuthorize($this->getOptionsForCompleteAuthorize())->send();

        $this->assertInstanceOf(RestCompleteAuthorizeResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
    }

    public function testCompleteAuthorizeFailure()
    {
        $this->setMockHttpResponse('RestCompleteAuthorizeFailedResponse.txt');

        $response = $this->gateway->completeAuthorize($this->getOptionsForCompleteAuthorize())->send();

        $this->assertInstanceOf(RestCompleteAuthorizeResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertNotNull($response->getErrorCode());
        $this->assertNotNull($response->getMessage());
    }

    public function testCaptureSuccess()
    {
        $this->setMockHttpResponse('RestCaptureResponse.txt');

        $response = $this->gateway->capture($this->getOptionsForCapture())->send();

        $this->assertInstanceOf(RestCaptureResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
    }

    public function testCaptureFailure()
    {
        $this->setMockHttpResponse('RestCaptureFailedResponse.txt');

        $response = $this->gateway->capture($this->getOptionsForCapture())->send();

        $this->assertInstanceOf(RestCaptureResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertNotNull($response->getErrorCode());
        $this->assertNotNull($response->getMessage());
    }

    public function testCancelSuccess()
    {
        $this->setMockHttpResponse('RestCancelResponse.txt');

        $response = $this->gateway->void($this->getOptionsForCancel())->send();

        $this->assertInstanceOf(RestCancelResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
    }

    public function testCancelFailure()
    {
        $this->setMockHttpResponse('RestCancelFailedResponse.txt');

        $response = $this->gateway->void($this->getOptionsForCancel())->send();

        $this->assertInstanceOf(RestCancelResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertNotNull($response->getErrorCode());
        $this->assertNotNull($response->getMessage());
    }

    public function testRefundSuccess()
    {
        $this->setMockHttpResponse('RestRefundResponse.txt');

        $response = $this->gateway->refund($this->getOptionsForRefund())->send();

        $this->assertInstanceOf(RestRefundResponse::class, $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
    }

    public function testRefundFailure()
    {
        $this->setMockHttpResponse('RestRefundFailedResponse.txt');

        $response = $this->gateway->refund($this->getOptionsForRefund())->send();

        $this->assertInstanceOf(RestRefundResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isPending());
        $this->assertFalse($response->isRedirect());
        $this->assertNotNull($response->getErrorCode());
        $this->assertNotNull($response->getMessage());
    }

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

    private function getOptionsForCapture()
    {
        return [
            'chargeId' => $this->getChargeId(),
            'amount' => $this->getAmount(),
        ];
    }

    private function getOptionsForCancel()
    {
        return [
            'chargeId' => $this->getChargeId(),
        ];
    }

    private function getOptionsForRefund()
    {
        return [
            'chargeId' => $this->getChargeId(),
            'amount' => $this->getAmount(),
            'reason' => 'Unwanted item',
        ];
    }
}
