<?php

namespace Tests\Unit\SkyHub\Resource;

class OrderTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateOrderResourceSuccessfully()
	{
		$actual = new \SkyHub\Resource\Order();
		$this->assertInstanceOf('\SkyHub\Resource\Order', $actual);
	}
}