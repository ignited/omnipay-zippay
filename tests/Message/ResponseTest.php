<?php

namespace Omnipay\ZipPay\Message;

use Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testConstruct()
    {
        // response should decode URL format data
        $response = new Response($this->getMockRequest(), ['example' => 'value', 'foo' => 'bar']);
        $this->assertEquals(array('example' => 'value', 'foo' => 'bar'), $response->getData());
    }
}
