<?php

namespace Tests\Unit\SkyHub\Resource;

class CategoryTest extends \PHPUnit_Framework_TestCase
{
	public function testCanInstantiateCategoryResourceSuccessfully()
	{
		$actual = new \GlauberPortella\SkyHub\Resource\Category();
		$this->assertInstanceOf('\GlauberPortella\SkyHub\Resource\Category', $actual);
	}

	public function testCategoryDynamicProperties()
	{
		$obj = new \GlauberPortella\SkyHub\Resource\Category();

		// not set
		$this->assertFalse(isset($obj->property));
		// is set
		$obj->property = 'value';
		$this->assertTrue(isset($obj->property));
		// test value
		$this->assertEquals('value', $obj->property);
		// unset
		$this->assertTrue(isset($obj->property));
		unset($obj->property);
		$this->assertFalse(isset($obj->property));
	}

	public function testConversionToJson()
	{
		$obj = new \GlauberPortella\SkyHub\Resource\Category();
		$obj->property1 = 'value 1';
		$obj->property_two = 'value 2';
		$obj->array_prop = array(
			'key1' => 'value_key1',
			'key2' => 'value_key2'
		);

		$encoded = json_encode($obj);

		$expectedJson = json_encode(array(
			'property1' => 'value 1',
			'property_two' => 'value 2',
			'array_prop' => array(
				'key1' => 'value_key1',
				'key2' => 'value_key2'
			)
		));

		$this->assertJsonStringEqualsJsonString($expectedJson, $encoded);

		$decoded = json_decode($encoded);
		$this->assertTrue(isset($decoded->property1));
		$this->assertTrue(isset($decoded->property_two));
		$this->assertTrue(isset($decoded->array_prop));
		$this->assertTrue(isset($decoded->array_prop->key1));
		$this->assertTrue(isset($decoded->array_prop->key2));
		// test values
		$this->assertEquals('value 1', $decoded->property1);
		$this->assertEquals('value 2', $decoded->property_two);
		$this->assertEquals('value_key1', $decoded->array_prop->key1);
		$this->assertEquals('value_key2', $decoded->array_prop->key2);
	}
}