<?php

namespace Tests\Unit\Integration\Products;

use Tests\Integration\IntegrationTestInterface;
use GlauberPortella\SkyHub\Resource\Category;

class CategoryTest extends \PHPUnit_Framework_TestCase
{
	private $auth;
	private $request;

	public function setUp()
	{
		$this->auth = new \GlauberPortella\SkyHub\Security\Auth(IntegrationTestInterface::USER_EMAIL, IntegrationTestInterface::USER_TOKEN);
		$this->request = new \GlauberPortella\SkyHub\Request\CategoryRequest($this->auth);
	}

	public function testGetRequestSuccessfullyInstantiated()
	{
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Request\CategoryRequest', $this->request);
	}

	public function testGet()
	{
		$resources = $this->request->get();
		$this->assertTrue(is_array($resources));
		$this->assertNotEmpty($resources);

		return count($resources);
	}

	// public function testPost()
	// {
	// 	$code = 'CatTest001';

	// 	$resource = new Category();
	// 	$resource->code = $code;
	// 	$resource->name = "Test category skyhub-php library";
	// 	$this->request->post($resource);

	// 	$resources = $this->request->get();
	// 	$this->assertEquals(1, count($resources));

	// 	return array('code' => $code, 'name' => $name);
	// }

	// /**
	//  * @depends testPost
	//  */
	// public function testPut(array $resourceData)
	// {
	// 	$codeExpected = $resourceData['code'];
	// 	$nameExpected = $resourceData['name'];

	// 	$resource = $this->request->get($codeExpected);
	// 	$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Category', $resource);

	// 	$this->assertEquals($codeExpected, $resource->code);
	// 	$this->assertEquals($nameExpected, $resource->nome);

	// 	$updatedNameExpected = 'Test category skyhub-php library updated';
	// 	$resource->name = $updatedNameExpected;
	// 	$this->request->put($resource);

	// 	$updated = $this->request->get($codeExpected);
	// 	$this->assertEquals($codeExpected, $resource->code);
	// 	$this->assertEquals($updatedNameExpected, $resource->nome);

	// 	return $resourceData;
	// }

	// /**
	//  * @depends testGet
	//  * @depends testPut
	//  */
	// public function testDelete($countResources, $resourceData)
	// {
	// 	$codeExpected = $resourceData['code'];
	// 	$nameExpected = $resourceData['name'];

	// 	$resource = $this->request->get($codeExpected);
	// 	$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Category', $resource);

	// 	$this->assertEquals($codeExpected, $resource->code);
	// 	$this->assertEquals($nameExpected, $resource->nome);

	// 	$this->request->delete($resource);

	// 	// test $newCount < $countResources
	// 	$resources = $this->request->get();
	// 	$newCount = count($resources);
	// 	$this->assertLessThan($countResources, $newCount);
	// }
}