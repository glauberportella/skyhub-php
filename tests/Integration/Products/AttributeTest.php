<?php

namespace Tests\Unit\Integration\Products;

use Tests\Integration\IntegrationTestInterface;
use SkyHub\Resource\Attribute;

class AttributeTest extends \PHPUnit_Framework_TestCase
{
	private $auth;
	private $request;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth(IntegrationTestInterface::USER_EMAIL, IntegrationTestInterface::USER_TOKEN);
		$this->request = new \SkyHub\Request\AttributeRequest($this->auth);
	}

	public function testGetRequestSuccessfullyInstantiated()
	{
		$this->assertInstanceOf('\SkyHub\Request\AttributeRequest', $this->request);
	}

	/*public function testPost()
	{
	 	$name = 'CatTest001';

	 	$resource = new Attribute();
	 	$resource->name = $name;
	 	$resource->label = "Test attribute skyhub-php library";
	 	$this->request->post($resource);

	 	$resource = $this->request->get($name);
	 	$this->assertInstanceOf('\SkyHub\Resource\Attribute', $resource);
	 	return array('code' => $code, 'label' => $name);
	}*/

	/**
	 * @depends testPost
	 */
	/*public function testPut(array $resourceData)
	{
		$nameExpected = $resourceData['name'];
		$labelExpected = $resourceData['label'];

		$resource = $this->request->get($nameExpected);
		$this->assertInstanceOf('\SkyHub\Resource\Attribute', $resource);

		$this->assertEquals($nameExpected, $resource->name);
		$this->assertEquals($labelExpected, $resource->label);

		$updatedNameExpected = 'Test attribute skyhub-php library updated';
		$resource->name = $updatedNameExpected;
		$this->request->put($resource);

		$updated = $this->request->get($nameExpected);
		$this->assertEquals($nameExpected, $resource->code);
		$this->assertEquals($updatedNameExpected, $resource->nome);

		return $resourceData;
	}*/

	/**
	 * @depends testGet
	 * @depends testPut
	 */
	/*public function testDelete($countResources, $resourceData)
	{
		$nameExpected = $resourceData['name'];
		$labelExpected = $resourceData['label'];

		$resource = $this->request->get($nameExpected);
		$this->assertInstanceOf('\SkyHub\Resource\Attribute', $resource);

		$this->assertEquals($nameExpected, $resource->code);
		$this->assertEquals($labelExpected, $resource->nome);

		$this->request->delete($resource);
	}*/
}