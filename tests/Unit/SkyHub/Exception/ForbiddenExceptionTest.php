<?php

namespace Tests\Unit\SkyHub\Exception;

class ForbiddenExceptionTest extends \PHPUnit_Framework_TestCase
{
	/**
     * @expectedException     		\GlauberPortella\SkyHub\Exception\ForbiddenException
     * @expectedExceptionCode 		403
     * @expectedExceptionMessage	A aplicação está tentando acessar um recurso ao qual não tem permissão.
     */
	public function testCanThrowSuccessfully()
	{
		throw new \GlauberPortella\SkyHub\Exception\ForbiddenException();
	}
}