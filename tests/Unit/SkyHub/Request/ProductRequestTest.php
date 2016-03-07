<?php

namespace Tests\Unit\SkyHub\Request;

class ProductRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
		$this->product = new \SkyHub\Resource\Product();
		$this->product->sku = '123';
		$this->product->name = "Produto de teste skyhub-php";
		$this->product->description = "Teste lib PHP para API SkyHub";
		$this->product->status = "enabled";
		$this->product->qty = 10;
		$this->product->price = 1000.50;
		$this->product->promotional_price = 850.50;
		$this->product->cost = 0;
		$this->product->weight = 5;
		$this->product->height = 15;
		$this->product->width = 30;
		$this->product->length = 15;
		$this->product->brand = "skyhub-php";
		$this->product->ean = "";
		$this->product->nbm = "";
		$this->product->categories = array(array (
		  "code" => "skyhub-php_123456",
		  "name" => "CatTeste_skyhub-php"
		));
		$this->product->images = array(
			'http://lorempixel.com/600/400/'
		);
		$this->product->specifications = array(
			array(
				"key" 	=> "Specification-test123",
				"value" => "Test skyhub-php lib"
			),
		);
		$this->product->variations = array(
		    array(
		      	"sku" 			=> "123-var",
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
		$this->product->variation_attributes = array(
			"Specification-var-test123"
		);
	}

	public function tearDown()
	{
		$this->auth = null;
		$this->product = null;
	}
	
	public function testCanInstantiateProductRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\ProductRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\ProductRequest', $actual);
	}

	public function testCreatePostBodyWithCorrectResourceRequestKey()
	{
		$this->assertEquals('product', $this->product->resourceRequestKey);

		$request = new \SkyHub\Request\ProductRequest($this->auth);
		$postBody = $request->createPostBody($this->product);
		$postBodyArray = json_decode($postBody, true);
		$this->assertArrayHasKey('product', $postBodyArray);
	}

	public function testCreatePutBodyWithCorrectResourceRequestKey()
	{
		$this->assertEquals('product', $this->product->resourceRequestKey);

		$request = new \SkyHub\Request\ProductRequest($this->auth);
		$putBody = $request->createPutBody($this->product);
		$putBodyArray = json_decode($putBody, true);
		$this->assertArrayHasKey('product', $putBodyArray);
	}
}