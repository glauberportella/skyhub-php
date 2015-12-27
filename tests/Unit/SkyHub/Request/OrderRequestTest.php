<?php

namespace Tests\Unit\SkyHub\Request;

class OrderRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateOrderRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\OrderRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\OrderRequest', $actual);
	}
}