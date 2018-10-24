<?php

namespace Tests\Unit\SkyHub\Request;

class ShipmentsB2WRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateShipmentsB2WRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\ShipmentsB2WRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\ShipmentsB2WRequest', $actual);
	}
}