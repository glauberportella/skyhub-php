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

	/**
	 * @depends testPost
	 */
	public function testDelete($resource)
	{
		try {
			$this->request->delete($resource);
			$this->assertTrue(true);
		} catch (\Exception $e) {
			$this->fail($e->getMessage());
		}
	}

	public function testGet()
	{
		$resources = $this->request->get();
		$this->assertTrue(is_array($resources) || $resources instanceof \SkyHub\Resource\Product, 'Resource is not an array or Product instance, maybe a SkyHub API invalid response on GET.');

		return $resources;
	}
	/**
	 * @depends testPost
	 */
	public function testGetOneProduct($resourceIn)
	{
		$resource = $this->request->get($resourceIn->sku);
		$this->assertInstanceOf('\SkyHub\Resource\Product', $resource, 'Not an instance of \SkyHub\Resource\Product.');

		return $resource;
	}

	public function testPost()
	{
		$ts = time();
		$sku = "sku-$ts";

		$resource = new Product();
		$resource->sku = $sku;
		$resource->name = "Produto de teste skyhub-php";
		$resource->description = "Teste lib PHP para API SkyHub";
		$resource->status = "enabled";
		$resource->qty = 10;
		$resource->price = 1000.50;
		$resource->promotional_price = 850.50;
		$resource->cost = 0;
		$resource->weight = 5;
		$resource->height = 15;
		$resource->width = 30;
		$resource->length = 15;
		$resource->brand = "skyhub-php";
		$resource->ean = "";
		$resource->nbm = "";
		$resource->categories = array(array (
		  "code" => "skyhub-php_123456",
		  "name" => "CatTeste_skyhub-php"
		));
		$resource->images = array(
			'http://lorempixel.com/600/400/'
		);
		$resource->specifications = array(
			array(
				"key" 	=> "Specification-test123",
				"value" => "Test skyhub-php lib"
			),
		);
		$resource->variations = array(
		    array(
		      	"sku" 			=> "$sku-var",
		      	"qty" 			=>  5,
		      	"ean" 			=> "",
		      	"images" 			=> array(
		      		'http://lorempixel.com/600/400/'
		      	),
		      	"specifications" 	=> array(
		        	array(
		          		"key"   => "Specification-var-test123",
		          		"value" => "Test skyhub-php lib spec variation"
		        	)
		      	)
		    )
		);
		$resource->variation_attributes = array(
			"Specification-var-test123"
		);

		try {
			$this->request->post($resource);
		} catch (\Exception $e) {
			$this->fail('Product test POST fail: '.$e->getMessage());
		}

		return $resource;
	}

	/**
	 * @depends testGetOneProduct
	 */
	public function testPut($resource)
	{
		try {
			$ts = time();
			$resource->name = "Produto de teste skyhub-php";
			$resource->description = "Teste lib PHP para API SkyHub - update - $ts";
			$resource->status = $resource->status == "enabled" ? "disabled" : "enabled";
			$resource->qty = 100;
			$this->request->put($resource);
		} catch (\Exception $e) {
			$this->fail('PUT failed: '.$e->getMessage());
		}
	}
}