<?php

namespace Tests\Unit\SkyHub\Request;

class AttributeRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}

	public function testCanInstantiateAttributeRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\AttributeRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\AttributeRequest', $actual);
	}
}