<?php

namespace Tests\Unit\SkyHub\Exception;

class NotAcceptableExceptionTest extends \PHPUnit_Framework_TestCase
{
	/**
     * @expectedException     		\SkyHub\Exception\NotAcceptableException
     * @expectedExceptionCode 		406
     * @expectedExceptionMessage	A SkyHub – API não suporta o formato de dados especificado no cabeçalho Accept.
     */
	public function testCanThrowSuccessfully()
	{
		throw new \SkyHub\Exception\NotAcceptableException();
	}
}