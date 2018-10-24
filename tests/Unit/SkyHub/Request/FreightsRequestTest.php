<?php

namespace Tests\Unit\SkyHub\Request;

class FreightsRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}
	
	public function testCanInstantiateFreightsRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\FreightsRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\FreightsRequest', $actual);
	}
}