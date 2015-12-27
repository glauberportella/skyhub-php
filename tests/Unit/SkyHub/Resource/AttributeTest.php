<?php

namespace Tests\Unit\SkyHub\Resource;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateAttributeResourceSuccessfully()
	{
		$actual = new \SkyHub\Resource\Attribute();
		$this->assertInstanceOf('\SkyHub\Resource\Attribute', $actual);
	}
}