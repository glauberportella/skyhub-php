<?php

namespace GlauberPortella\Tests\Unit\SkyHub\Request;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth();
	}

	public function testClassnameIsTheCorrectOne()
	{
		$attribute = new \GlauberPortella\SkyHub\Resource\Attribute;
		$classname = get_class($attribute);
		$this->assertEquals('GlauberPortella\SkyHub\Resource\Attribute', $classname);
	}

	public function testConcreteRequestMustBeInstantiated()
	{
		// attributes
		$attribute = new \GlauberPortella\SkyHub\Resource\Attribute;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::create($this->auth)->forResource($attribute);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Attribute', $request);

		$category = new \GlauberPortella\SkyHub\Resource\Category;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::create($this->auth)->forResource($category);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Category', $request);

		$order = new \GlauberPortella\SkyHub\Resource\Order;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::create($this->auth)->forResource($order);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Order', $request);

		$orderStatus = new \GlauberPortella\SkyHub\Resource\OrderStatus;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::create($this->auth)->forResource($orderStatus);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\OrderStatus', $request);

		$product = new \GlauberPortella\SkyHub\Resource\Product;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::create($this->auth)->forResource($product);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Product', $request);
	}
}