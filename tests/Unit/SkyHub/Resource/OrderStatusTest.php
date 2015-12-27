<?php

namespace Tests\Unit\SkyHub\Resource;

class OrderStatusTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateOrderStatusResourceSuccessfully()
	{
		$actual = new \SkyHub\Resource\OrderStatus();
		$this->assertInstanceOf('\SkyHub\Resource\OrderStatus', $actual);
	}
}