<?php

namespace Tests\Unit\SkyHub\Request;

class ProductRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateProductRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\ProductRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\ProductRequest', $actual);
	}
}