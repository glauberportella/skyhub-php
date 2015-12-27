<?php

namespace Tests\Unit\SkyHub\Resource;

class CategoryTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateCategoryResourceSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Resource\Category();
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Category', $actual);
	}
}