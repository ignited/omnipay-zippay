<?php

namespace Omnipay\ZipPay\Message;

use Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testConstruct()
    {
        $mockHeaders = ['a' => ['b'], 'c' => ['d']];

        // response should decode URL format data
        $response = new Response(
            $this->getMockRequest(),
            ['example' => 'value', 'foo' => 'bar'],
            $mockHeaders,
            200
        );
        $this->assertEquals(array('example' => 'value', 'foo' => 'bar'), $response->getData());
        $this->assertEquals($mockHeaders, $response->getHeaders());
    }
}
