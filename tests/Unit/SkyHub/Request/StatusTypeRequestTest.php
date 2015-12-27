<?php

namespace Tests\Unit\SkyHub\Request;

class StatusTypeRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateOrderStatusRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\StatusTypeRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\StatusTypeRequest', $actual);
	}
}