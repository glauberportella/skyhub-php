<?php

namespace Tests\Unit\SkyHub\Request;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}

	public function testClassnameIsTheCorrectOne()
	{
		$attribute = new \SkyHub\Resource\Attribute;
		$classname = get_class($attribute);
		$this->assertEquals('SkyHub\Resource\Attribute', $classname);
	}

	public function testConcreteRequestMustBeInstantiatedFromResource()
	{
		$attribute = new \SkyHub\Resource\Attribute;
		$request = \SkyHub\Request\RequestFactory::fromResource($attribute, $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\AttributeRequest', $request);

		$category = new \SkyHub\Resource\Category;
		$request = \SkyHub\Request\RequestFactory::fromResource($category, $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\CategoryRequest', $request);

		$order = new \SkyHub\Resource\Order;
		$request = \SkyHub\Request\RequestFactory::fromResource($order, $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\OrderRequest', $request);

		$orderStatus = new \SkyHub\Resource\OrderStatus;
		$request = \SkyHub\Request\RequestFactory::fromResource($orderStatus, $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\OrderStatusRequest', $request);

		$product = new \SkyHub\Resource\Product;
		$request = \SkyHub\Request\RequestFactory::fromResource($product, $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\ProductRequest', $request);
	}

	public function testConcreteRequestMustBeInstantiatedFromClassname()
	{
		$request = \SkyHub\Request\RequestFactory::fromClassName('\SkyHub\Request\AttributeRequest', $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\AttributeRequest', $request);

		$request = \SkyHub\Request\RequestFactory::fromClassName('\SkyHub\Request\CategoryRequest', $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\CategoryRequest', $request);

		$request = \SkyHub\Request\RequestFactory::fromClassName('\SkyHub\Request\OrderRequest', $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\OrderRequest', $request);

		$request = \SkyHub\Request\RequestFactory::fromClassName('\SkyHub\Request\OrderStatusRequest', $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\OrderStatusRequest', $request);

		$request = \SkyHub\Request\RequestFactory::fromClassName('\SkyHub\Request\ProductRequest', $this->auth);
		$this->assertInstanceOf('\SkyHub\Request\ProductRequest', $request);
	}
}