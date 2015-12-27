<?php

namespace Tests\Unit\SkyHub\Request;

class OrderRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateOrderRequestSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Request\OrderRequest($this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\OrderRequest', $actual);
	}
}