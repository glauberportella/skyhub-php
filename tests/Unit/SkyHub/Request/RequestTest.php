<?php

namespace Tests\Unit\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth();
	}
	
	public function testApiSkyHubEndpointSuccessfully()
	{
		$attributes = new \GlauberPortella\SkyHub\Request\AttributeRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/attributes', $attributes->endpoint());

		$categories = new \GlauberPortella\SkyHub\Request\CategoryRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/categories', $categories->endpoint());

		$orders = new \GlauberPortella\SkyHub\Request\OrderRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/orders', $orders->endpoint());

		$products = new \GlauberPortella\SkyHub\Request\ProductRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/products', $products->endpoint());

		$statusTypes = new \GlauberPortella\SkyHub\Request\StatusTypeRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/status_types', $statusTypes->endpoint());
	}
}