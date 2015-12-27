<?php

namespace Tests\Unit\SkyHub\Resource;

class CategoryTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateCategoryResourceSuccessfully()
	{
		$actual = new \SkyHub\Resource\Category();
		$this->assertInstanceOf('\SkyHub\Resource\Category', $actual);
	}
}