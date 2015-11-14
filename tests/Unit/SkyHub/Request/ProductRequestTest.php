<?php

namespace Tests\Unit\SkyHub\Request;

class ProductRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateProductRequestSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Request\ProductRequest($this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\ProductRequest', $actual);
	}
}