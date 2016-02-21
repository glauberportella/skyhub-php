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
		$resource->code = 'Submarino-1455563835202';
		$resource->status = '6';
		$this->request->cancel($resource);
	}

	public function testDelivery()
	{
		$resource = new Order();
		$resource->code = 'Submarino-1455563835202';
		$resource->status = '5';
		$this->request->delivery($resource);
	}

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
		$resource = new \SkyHub\Resource\Order();
		$resource->channel = "Submarino";
		//$resource->status = "pagamento_pendente";
		$resource->items = array(
			array("id" => 1, "qty" => 1),
		);
		$resource->customer = array(
		    "name" => "Glauber Portella",
		    "email" => "glauberportella@gmail.com",
		    "date_of_birth" => "1982-01-12",
		    "gender" => "masculino",
		    "vat_number" => "05771095613",
		    "phones" => array('(31) 3433-5488', '(31) 99246-8610')
		);
		$resource->billing_address = array(
			"street" => "Rua dos Alvarengas",
			"number" => "40",
			"detail" => "",
			"neighborhood" => "Aarão Reis",
			"city" => "Belo Horizonte",
			"region" => "MG",
			"country" => "Brasil",
			"post_code" => "31814500"
		);
		$resource->shipping_address = array(
			"street" => "Rua dos Alvarengas",
			"number" => "40",
			"detail" => "",
			"neighborhood" => "Aarão Reis",
			"city" => "Belo Horizonte",
			"region" => "MG",
			"country" => "Brasil",
			"post_code" => "31814500"
		);
  		$resource->shipping_method = "Correios PAC";

  		$estimatedDelivery = new \DateTime();
		$estimatedDelivery->add(new \DateInterval('P15D'));
		$resource->estimated_delivery = $estimatedDelivery->format('Y-m-d');
		$resource->shipping_cost = 17.50;
		$resource->interest = 0;

		try {
			$this->request->createTest($resource);
		} catch (Exception $e) {
			$this->fail('Request fail on OrderRequest::createTest()');
		}
	}
}