<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestInterface;
use SkyHub\Resource\SaleSystem;

class SaleSystemTest extends \PHPUnit_Framework_TestCase
{
	private $auth;
	private $request;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth(IntegrationTestInterface::USER_EMAIL, IntegrationTestInterface::USER_TOKEN);
		$this->request = new \SkyHub\Request\SaleSystemRequest($this->auth);
	}

	public function testGetRequestSuccessfullyInstantiated()
	{
		$this->assertInstanceOf('\SkyHub\Request\SaleSystemRequest', $this->request);
	}

	public function testGet()
	{
		$resources = $this->request->get();
		$this->assertTrue(is_array($resources));
	}

	/**
	 * @expectedException \SkyHub\Exception\MethodNotAllowedException
	 */
	public function testPost()
	{
		$resource = new SaleSystem();
		$resource->name = 'Teste1';
		$this->request->post($resource);
	}

	/**
	 * @expectedException \SkyHub\Exception\MethodNotAllowedException
	 */
	public function testPut()
	{
		$resource = new SaleSystem();
		$resource->code = '001';
		$resource->name = 'Teste1';
		$this->request->put($resource);
	}

	/**
	 * @expectedException \SkyHub\Exception\MethodNotAllowedException
	 */
	public function testDelete()
	{
		$this->request->delete('Teste1');
	}
}