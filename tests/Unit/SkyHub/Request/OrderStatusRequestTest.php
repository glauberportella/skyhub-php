<?php

namespace Tests\Unit\SkyHub\Request;

class OrderStatusRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateOrderStatusRequestSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Request\OrderStatusRequest($this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\OrderStatusRequest', $actual);
	}
}