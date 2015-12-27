<?php

namespace Tests\Unit\SkyHub\Security;

class AuthTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateAuthSuccess()
	{
		$auth = new \SkyHub\Security\Auth();
		$this->assertInstanceOf('\SkyHub\Security\Auth', $auth);
	}
}