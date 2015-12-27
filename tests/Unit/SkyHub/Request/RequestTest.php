<?php

namespace Tests\Unit\SkyHub\Request;

use \SkyHub\Request\Request;
use \SkyHub\Resource\ApiResource;

class RequestConcrete extends Request {
	protected $resourceClassName = '\SkyHub\Resource\Product';
	public function endpoint()
	{
		return 'http://localhost:8000/resources';
	}
	public function get($code = null, array $params = array()) {}
	public function post(ApiResource $resource) {}
    public function put($code, ApiResource $resource) {}
    public function delete($code) {}
}

class RequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth();
	}

	public function testApiSkyHubEndpointSuccessfully()
	{
		$attributes = new \SkyHub\Request\AttributeRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/attributes', $attributes->endpoint());

		$categories = new \SkyHub\Request\CategoryRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/categories', $categories->endpoint());

		$orders = new \SkyHub\Request\OrderRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/orders', $orders->endpoint());

		$products = new \SkyHub\Request\ProductRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/products', $products->endpoint());

		$statusTypes = new \SkyHub\Request\StatusTypeRequest($this->auth);
		$this->assertEquals('https://in.skyhub.com.br/status_types', $statusTypes->endpoint());
	}

	public function testGenerateUrl()
	{
		$request = new RequestConcrete($this->auth);
		
		$urlNoPathNoParam = $request->generateUrl();
		$this->assertEquals('http://localhost:8000/resources', $urlNoPathNoParam);

		$urlNoPathWithParams = $request->generateUrl(null, array('param1' => 'val1', 'param2'=>'val2', 'param3'=>array('val31', 'val32', 'val33')));
		$this->assertEquals('http://localhost:8000/resources?param1=val1&param2=val2&param3[0]=val31&param3[1]=val32&param3[2]=val33', urldecode($urlNoPathWithParams));

		$url = $request->generateUrl('Resource-Code', array('param1'=>'val1','param2'=>array('val21', 'val22', 'val23'=>array(1,2,3))));
		$this->assertEquals('http://localhost:8000/resources/Resource-Code?param1=val1&param2[0]=val21&param2[1]=val22&param2[val23][0]=1&param2[val23][1]=2&param2[val23][2]=3', urldecode($url));

	}

	public function testResponseToResource()
	{
		$request = new RequestConcrete($this->auth);

		$mockResponse = $this->getMockBuilder('\Httpful\Response')
			->disableOriginalConstructor()
			->getMock();

		$mockResponse->body = json_decode(json_encode(array(
			'property1' => 'Val1',
			'property2' => 'Val2',
			'property3' => 'Val3',
			'property4' => array('p1' => 'val41')
		)));

		$resource = $request->responseToResources($mockResponse);
		$this->assertInstanceOf('\SkyHub\Resource\Product', $resource);

		$this->assertEquals('Val1', $resource->property1);
		$this->assertEquals('Val2', $resource->property2);
		$this->assertEquals('Val3', $resource->property3);
		$this->assertEquals('val41', $resource->property4->p1);

		// $this->assertObjectHasAttribute('property1', $resource, $message = 'Attribute property1 not exist on resource.');
		// $this->assertObjectHasAttribute('property2', $resource, $message = 'Attribute property2 not exist on resource.');
		// $this->assertObjectHasAttribute('property3', $resource, $message = 'Attribute property3 not exist on resource.');
		// $this->assertObjectHasAttribute('property4', $resource, $message = 'Attribute property4 not exist on resource.');
		// $this->assertObjectHasAttribute('p1', $resource->property4->p1, $message = 'Attribute p1 not exist on resource->property4.');
	}
}