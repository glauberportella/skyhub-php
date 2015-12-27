<?php

namespace Tests\Unit\SkyHub\Resource;

class OrderTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateOrderResourceSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Resource\Order();
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Order', $actual);
	}
}