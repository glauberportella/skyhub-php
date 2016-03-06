<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestInterface;
use SkyHub\Resource\Order;

class OrderTest extends \PHPUnit_Framework_TestCase
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

	/**
	 * @expectedException \SkyHub\Exception\SemanticalErrorException
	 */
	public function testCancel()
	{
		$resource = new Order();
		$resource->code = 'Submarino-1455563835202';
		$resource->status = '6';
		$this->request->cancel($resource);
	}

	/**
	 * @expectedException \SkyHub\Exception\SemanticalErrorException
	 */
	public function testDelivery()
	{
		$resource = new Order();
		$resource->code = 'Submarino-1455563835202';
		$resource->status = '5';
		$this->request->delivery($resource);
	}

	/**
	 * @expectedException \SkyHub\Exception\SemanticalErrorException
	 */
	public function testShipments()
	{
		$resource = new Order();
		$resource->code = 'Submarino-1455563835202';
		$resource->status = '4';
		$resource->shipment = array(
			'code' => 'skyhub-shipment-4', // shipment code
			// shipment itens
			'items' => array(
				array('sku' => '1', 'qty' => 1)
			), // items added below
			// track info
			'track' => array(
				'code' => '123456789123456789', // track code
				'carrier' => 'Correios', // carrier, setting below
				'method' => 'PAC' // shipment method, setting below
			),
		);
		$resource->invoice = array(
			'key' => '123456789-ABCDEF' // NF-e key
		);

		$this->request->shipments($resource);
	}

	public function testExported()
	{
		$resource = new Order();
		$resource->code = 'Submarino-1455978238246';
		$resource->exported = true;
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

	public function testGetNotSynced()
	{
		$notSynced = $this->request->getNotSynced();
		$this->assertTrue(is_array($notSynced) || $notSynced instanceof \SkyHub\Resource\Order, 'Resource is not an array or Order instance, maybe a SkyHub API invalid response on GET or there is no NOT_SYNCED orders.');
	}

	public function testCreateTest()
	{
		$order = new \SkyHub\Resource\Order();
		
		$order->channel = "Submarino";
		$order->status = "11";
		$order->items = array(
		    array("id" => "1", "qty" => 1),
		);

		$order->customer = array(
		    "name" => "Glauber Portella",
		    "email" => "exemplo@skyhub.com.br",
		    "date_of_birth" => "1998-01-25",
		    "gender" => "male",
		    "vat_number" => "78732371683",
		    "phones" => array("21 3722-3902")
		);

		$order->billing_address = array(
		    "street" => "Rua Sacadura Cabral",
		    "number" => "130",
		    "detail" => "",
		    "neighborhood" => "Centro",
		    "city" => "Rio de Janeiro",
		    "region" => "RJ",
		    "country" => "BR",
		    "post_code" => "20081262"
		);

		$order->shipping_address = array(
		    "street" => "Rua Sacadura Cabral",
		    "number" => "130",
		    "detail" => "",
		    "neighborhood" => "Centro",
		    "city" => "Rio de Janeiro",
		    "region" => "RJ",
		    "country" => "BR",
		    "post_code" => "20081262"
		);

		$order->shipping_method = "Correios PAC";
		$order->estimated_delivery = "2017-02-11";
		$order->shipping_cost = 15.32;
		$order->interest = 3.54;

		try {
			$this->request->createTest($order);
		} catch (Exception $e) {
			$this->fail('Request fail on OrderRequest::createTest()');
		}
	}
}