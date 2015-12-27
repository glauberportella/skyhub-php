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

	public function testConcreteRequestMustBeInstantiatedFromResource()
	{
		$attribute = new \GlauberPortella\SkyHub\Resource\Attribute;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromResource($attribute, $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\AttributeRequest', $request);

		$category = new \GlauberPortella\SkyHub\Resource\Category;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromResource($category, $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\CategoryRequest', $request);

		$order = new \GlauberPortella\SkyHub\Resource\Order;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromResource($order, $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\OrderRequest', $request);

		$orderStatus = new \GlauberPortella\SkyHub\Resource\OrderStatus;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromResource($orderStatus, $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\OrderStatusRequest', $request);

		$product = new \GlauberPortella\SkyHub\Resource\Product;
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromResource($product, $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\ProductRequest', $request);
	}

	public function testConcreteRequestMustBeInstantiatedFromClassname()
	{
		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromClassName('\GlauberPortella\SkyHub\Request\AttributeRequest', $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\AttributeRequest', $request);

		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromClassName('\GlauberPortella\SkyHub\Request\CategoryRequest', $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\CategoryRequest', $request);

		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromClassName('\GlauberPortella\SkyHub\Request\OrderRequest', $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\OrderRequest', $request);

		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromClassName('\GlauberPortella\SkyHub\Request\OrderStatusRequest', $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\OrderStatusRequest', $request);

		$request = \GlauberPortella\SkyHub\Request\RequestFactory::fromClassName('\GlauberPortella\SkyHub\Request\ProductRequest', $this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\ProductRequest', $request);
	}
}