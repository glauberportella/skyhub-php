<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestInterface;
use SkyHub\Resource\Product;

class ProductTest extends \PHPUnit_Framework_Testcase
{
	private $auth;
	private $request;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth(IntegrationTestInterface::USER_EMAIL, IntegrationTestInterface::USER_TOKEN);
		$this->request = new \SkyHub\Request\ProductRequest($this->auth);
	}

	/**
	 * @expectedException \SkyHub\Exception\MethodNotAllowedException
	 */
	public function testDelete()
	{
		$this->request->delete('10001');
	}

	public function testGet()
	{

	}
}