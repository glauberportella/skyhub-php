<?php

namespace Tests\Unit\SkyHub\Request;

class CategoryRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateCategoryRequestSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Request\CategoryRequest($this->auth);
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\CategoryRequest', $actual);
	}
}