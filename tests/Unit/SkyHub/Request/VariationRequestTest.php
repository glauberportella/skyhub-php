<?php

namespace Tests\Unit\SkyHub\Request;

class VariationRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}

	public function testCanInstantiateVariationRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\VariationRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\VariationRequest', $actual);
	}
}