<?php

namespace Tests\Unit\SkyHub\Exception;

class SkyHubExceptionTest extends \PHPUnit_Framework_TestCase
{
	public function testJsonSerializableShouldWorks()
	{
		$exception = new \SkyHub\Exception\ForbiddenException();
		$this->assertInstanceOf('\SkyHub\Exception\ForbiddenException', $exception);

		$jsonDeserialized = json_decode(json_encode($exception), true);

		$this->assertEquals('SkyHub\Exception\ForbiddenException', $jsonDeserialized['exception']);
		$this->assertEquals(403, $jsonDeserialized['code']);
		$this->assertEquals('SkyHub API - A aplicação está tentando acessar um recurso ao qual não tem permissão.', $jsonDeserialized['message']);
	}
}