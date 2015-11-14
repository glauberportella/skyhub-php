<?php

namespace Tests\Unit\Integration\Products;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth();
	}

	public function testGetRequestSuccessfully()
	{
		$request = new \GlauberPortella\SkyHub\Request\AttributeRequest($this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\AttributeRequest', $request);
	}
}