<?php

namespace Tests\Unit\SkyHub\Security;

class AuthTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateAuthSuccess()
	{
		$auth = new \GlauberPortella\SkyHub\Security\Auth();
		$this->assertInstanceOf('GlauberPortella\SkyHub\Security\Auth', $auth);
	}
}