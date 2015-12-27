<?php

namespace Tests\Unit\SkyHub\Resource;

class ProductTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateProductResourceSuccessfully()
	{
		$actual = new \SkyHub\Resource\Product();
		$this->assertInstanceOf('\SkyHub\Resource\Product', $actual);
	}
}