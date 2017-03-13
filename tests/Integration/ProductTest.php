<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestInterface;
use SkyHub\Resource\Product;

class ProductTest extends \PHPUnit_Framework_Testcase
{
	private $auth;
	private $request;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth(IntegrationTestInterface::USER_EMAIL, IntegrationTestInterface::USER_TOKEN);
		$this->request = new \SkyHub\Request\ProductRequest($this->auth);
	}

	public function testPostAndDelete()
	{
		$resource = TestProductFactory::factory();

		try {
			$this->request->post($resource);
			$this->request->delete($resource);
		} catch (\Exception $e) {
			$this->fail('Product test POST and DELETE fail: '.$e->getMessage());
		}

		return $resource;
	}

	public function testGet()
	{
		$resources = $this->request->get();
		$this->assertTrue(is_array($resources) || $resources instanceof \SkyHub\Resource\Product, 'Resource is not an array or Product instance, maybe a SkyHub API invalid response on GET.');
	}

	public function testGetOneProduct()
	{
		$new = TestProductFactory::factory();

		try {
			$this->request->post($new);
			$resource = $this->request->get($new->sku);
			$this->assertInstanceOf('\SkyHub\Resource\Product', $resource, 'Not an instance of \SkyHub\Resource\Product.');
			
			$this->request->delete($resource);
		} catch (\Exception $e) {
			$this->fail('Product test POST fail: '.$e->getMessage());
		}
	}

	public function testPut()
	{
		try {
			$new = TestProductFactory::factory();
			$this->request->post($new);
			// update data on product
			$ts = time();
			$new->name = "Produto de teste skyhub-php";
			$new->description = "Teste lib PHP para API SkyHub - update - $ts";
			$new->status = $new->status == "enabled" ? "disabled" : "enabled";
			$new->qty = 100;
			$this->request->put($new);
		} catch (\Exception $e) {
			$this->fail('PUT failed: '.$e->getMessage());
		}
	}
}