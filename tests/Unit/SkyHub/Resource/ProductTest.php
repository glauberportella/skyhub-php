<?php

namespace Tests\Unit\SkyHub\Resource;

class ProductTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateProductResourceSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Resource\Product();
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Product', $actual);
	}
}