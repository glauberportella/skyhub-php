<?php

namespace Tests\Unit\Integration;

use Tests\Integration\IntegrationTestInterface;
use SkyHub\Resource\OrderStatus;

class OrderStatusTest extends \PHPUnit_Framework_TestCase
{
	private $auth;
	private $request;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth(IntegrationTestInterface::USER_EMAIL, IntegrationTestInterface::USER_TOKEN);
		$this->request = new \SkyHub\Request\OrderStatusRequest($this->auth);
	}

	public function testGetRequestSuccessfullyInstantiated()
	{
		$this->assertInstanceOf('\SkyHub\Request\OrderStatusRequest', $this->request);
	}

	public function testGet()
	{
		$resources = $this->request->get();
		$this->assertTrue(is_array($resources));
		return $resources;
	}

	/**
	 * @depends testGet
	 */
	public function testPost($resources)
	{
		$testReturn = null;

		$ts = time();
		$code = "StatusTest001";
		$label = "Test order status skyhub-php library - $ts";
		$type = 'NEW';
		
		// see if can create a new status
		$canCreate = true;
		foreach ($resources as $resource) {
			if ($resource->code == $code) {
				$canCreate = false;
				$testReturn = $resource;
				break;
			}
		}

		if ($canCreate) {
			$resource = new OrderStatus();
			$resource->code = $code;
			$resource->label = $label;
			$resource->type = $type;
			try {
				$this->request->post($resource);
				$testReturn = $resource;
			} catch (\Exception $e) {
				$this->fail($e->getMessage());
			}
		}


		return $testReturn;
	}

	/**
	 * @depends testPost
	 */
	public function testPut($resource)
	{
		try {
			$ts = time();
			$resource->label = "Test order status skyhub-php library - update - $ts";
			$this->request->put($resource);
		} catch (\Exception $e) {
			$this->fail($e->getMessage());
		}
	}
}