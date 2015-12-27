<?php

namespace Tests\Unit\SkyHub\Resource;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateAttributeResourceSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Resource\Attribute();
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Attribute', $actual);
	}
}