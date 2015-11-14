<?php

namespace Tests\Unit\SkyHub\Request;

class AttributeRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth();
	}

	public function testCanInstantiateAttributeRequestSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Request\AttributeRequest($this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\AttributeRequest', $actual);
	}
}