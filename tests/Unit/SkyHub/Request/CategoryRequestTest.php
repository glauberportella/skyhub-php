<?php

namespace Tests\Unit\SkyHub\Request;

class CategoryRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateCategoryRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\CategoryRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\CategoryRequest', $actual);
	}
}