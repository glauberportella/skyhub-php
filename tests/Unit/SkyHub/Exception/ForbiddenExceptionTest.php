<?php

namespace Tests\Unit\SkyHub\Exception;

class ForbiddenExceptionTest extends \PHPUnit_Framework_TestCase
{
	/**
     * @expectedException     		\SkyHub\Exception\ForbiddenException
     * @expectedExceptionCode 		403
     * @expectedExceptionMessage	A aplicação está tentando acessar um recurso ao qual não tem permissão.
     */
	public function testCanThrowSuccessfully()
	{
		throw new \SkyHub\Exception\ForbiddenException();
	}
}