<?php

namespace Tests\Integration;

use Tests\Integration\IntegrationTestInterface;
use SkyHub\Resource\Category;

class CategoryTest extends \PHPUnit_Framework_TestCase
{
	private $auth;
	private $request;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth(IntegrationTestInterface::USER_EMAIL, IntegrationTestInterface::USER_TOKEN);
		$this->request = new \SkyHub\Request\CategoryRequest($this->auth);
	}

	public function testGetRequestSuccessfullyInstantiated()
	{
		$this->assertInstanceOf('\SkyHub\Request\CategoryRequest', $this->request);
	}

	public function testGet()
	{
		$resources = $this->request->get();
		$this->assertTrue(is_array($resources));
		$this->assertNotEmpty($resources);

		return $resources;
	}

	public function testPost()
	{
		$ts = time();
		$code = "CatTest-$ts";
		$name = "Test category $ts";

		try {
			$resource = new Category();
			$resource->code = $code;
			$resource->name = $name;
			$this->request->post($resource);
			$resources = $this->request->get();
			$this->assertTrue(count($resources) > 1);
		} catch (\Exception $e) {
			file_put_contents('teste.log', json_encode($e));
			$this->fail($e->getMessage());
		}

		return array('code' => $code, 'name' => $name);
	}

	/**
	 * @depends testGet
	 */
	public function testPut($resources)
	{
		// find test category
		$resource = null;
		foreach ($resources as $cat) {
			if (1 === preg_match('/Teste/i', $cat->code)) {
				$resource = $cat;
				break;
			}
		}

		if (is_null($resource)) {
			$this->fail('SkyHub API no resource with "Teste" string on code to test PUT method.');
		}

		try {
			$ts = time();
			$resource->name = "Test category skyhub-php library - $ts";
			$this->request->put($resource);
		} catch (\Exception $e) {
			$this->fail($e->getMessage());
		}
	}
}