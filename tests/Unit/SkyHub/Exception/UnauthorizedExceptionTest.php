<?php

namespace Tests\Unit\SkyHub\Exception;

class UnauthorizedExceptionTest extends \PHPUnit_Framework_TestCase
{
	/**
     * @expectedException     		\SkyHub\Exception\UnauthorizedException
     * @expectedExceptionCode 		401
     * @expectedExceptionMessage	O cabeçalho (header) da requisição não contém (ou estão errados) os dados de acesso: e-mail e/ou token.
     */
	public function testCanThrowSuccessfully()
	{
		throw new \SkyHub\Exception\UnauthorizedException();
	}
}