<?php

namespace Tests\Unit\SkyHub\Request;

class StatusTypeRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateOrderStatusRequestSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Request\StatusTypeRequest($this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\StatusTypeRequest', $actual);
	}
}