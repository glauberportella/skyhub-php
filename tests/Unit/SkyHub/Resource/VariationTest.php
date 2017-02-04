<?php

namespace Tests\Unit\SkyHub\Resource;

class VariationTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateVariationResourceSuccessfully()
	{
		$actual = new \SkyHub\Resource\Variation();
		$this->assertInstanceOf('\SkyHub\Resource\Variation', $actual);
	}

	public function testVariationGet()
	{
		$auth = new \SkyHub\Security\Auth();
		$fakeVariation = new \SkyHub\Resource\Variation();
		$fakeVariation->sku = 'skhb-1-var-1';

		$request = $this->getMockBuilder('\SkyHub\Request\VariationRequest')
			->setConstructorArgs(array($auth))
			->getMock();
		$request->method('get')
			->with($this->equalTo('skhb-1-var-1'))
			->willReturn($fakeVariation);

		$variation = $request->get($fakeVariation->sku);
		$this->assertEquals($fakeVariation, $variation);
	}
}