<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestInterface;
use SkyHub\Resource\Order;

class OrderTest extends \PHPUnit_Framework_Testcase
{
	private $auth;
	private $request;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth(IntegrationTestInterface::USER_EMAIL, IntegrationTestInterface::USER_TOKEN);
		$this->request = new \SkyHub\Request\OrderRequest($this->auth);
	}

	public function testGet()
	{
		$resources = $this->request->get();
		$this->assertTrue(is_array($resources) || $resources instanceof \SkyHub\Resource\Order, 'Resource is not an array or Order instance, maybe a SkyHub API invalid response on GET.');

		$resources = $this->request->get(null, array(
			'page' => 1,
			'per_page' => 100,
			'filters' => array(
				'sale_system' => 'TESTE',
				'statuses' => array('NEW', 'APPROVED'),
				'sync_status' => array('SYNCED', 'NOT_SYNCED', 'ERROR')
			)
		));
		$this->assertTrue(is_array($resources) || $resources instanceof \SkyHub\Resource\Order, 'Resource is not an array or Order instance, maybe a SkyHub API invalid response on GET.');
	}

	/**
	 * @expectedException \SkyHub\Exception\NotFoundException
	 */
	public function testGetOneOrderFail()
	{
		$resource = $this->request->get('1001');
	}

	public function testCancel()
	{
		$resource = new Order();
		$resource->code = '1001';
		$this->request->cancel($resource);
	}

	public function testDelivery()
	{
		$resource = new Order();
		$resource->code = '1001';
		$this->request->delivery($resource);
	}

	public function testShipments()
	{
		$resource = new Order();
		$resource->code = '1001';
		$this->request->shipments($resource);
	}

	public function testExported()
	{
		$resource = new Order();
		$resource->code = '1001';
		$resource->exported = false;
		$this->request->exported($resource);
	}

	/**
	 * @expectedException \SkyHub\Exception\MethodNotAllowedException
	 */
	public function testDelete()
	{
		$this->request->delete('10001');
	}

	/**
	 * @expectedException \SkyHub\Exception\MethodNotAllowedException
	 */
	public function testPost()
	{
		$resource = new Order();
		$this->request->post($resource);
	}

	/**
	 * @expectedException \SkyHub\Exception\MethodNotAllowedException
	 */
	public function testPut()
	{
		$resource = new Order();
		$this->request->put($resource);
	}


}