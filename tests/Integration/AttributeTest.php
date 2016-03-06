<?php

namespace Tests\Integration;

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

	/**
	 * @expectedException \SkyHub\Exception\MethodNotAllowedException
	 */
	public function testGet()
	{
		$this->request->get('AttributeTeste001');
	}

	/**
	 * @expectedException \SkyHub\Exception\MethodNotAllowedException
	 */
	public function testDelete()
	{
		$this->request->delete('AttributeTeste001');
	}

	/*public function testPost()
	{
		$ts = time();
	 	$name = "AttributeTeste-$ts";

	 	$resource = new Attribute();
	 	$resource->code = $name;
	 	$resource->name = $name;
	 	$resource->label = "Test attribute skyhub-php library - $ts";
	 	$resource->options = array(
	 		'Teste-$ts opção 1',
	 		'Teste-$ts opção 2',
 		);
	 	
	 	try {
		 	$this->request->post($resource);
	 	} catch (\Exception $e) {
	 		$this->fail($e->getMessage());
	 	}

	 	return $resource;
	}*/

	public function testFakeGet()
	{
		$resource = new Attribute();
		$resource->code = 'AttributeTeste-1451259323';
		return $resource;
	}

	/**
	 * @depends testFakeGet
	 */
	public function testPut($resource)
	{
		$ts = time();
		$resource->name = "AttributeTeste-$ts";
		$resource->label = "Test attribute skyhub-php library updated - $ts";
		try {
			$this->request->put($resource);
		} catch (\Exception $e) {
			$this->fail($e->getMessage());
		}
	}
}