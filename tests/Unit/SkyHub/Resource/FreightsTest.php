<?php

namespace Tests\Unit\SkyHub\Resource;

class FreightsTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateFreightsResourceSuccessfully()
	{
		$actual = new \SkyHub\Resource\Freights();
		$this->assertInstanceOf('\SkyHub\Resource\Freights', $actual);
	}
}