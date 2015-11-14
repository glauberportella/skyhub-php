<?php

namespace Tests\Unit\SkyHub\Resource;

class OrderStatusTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateOrderStatusResourceSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Resource\OrderStatus();
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\OrderStatus', $actual);
	}
}