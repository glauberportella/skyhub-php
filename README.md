[![Code Climate](https://codeclimate.com/github/glauberportella/skyhub-php/badges/gpa.svg)](https://codeclimate.com/github/glauberportella/skyhub-php) [![Test Coverage](https://codeclimate.com/github/glauberportella/skyhub-php/badges/coverage.svg)](https://codeclimate.com/github/glauberportella/skyhub-php/coverage)

# A PHP Library for SkyHub API

The purpose of this lib is to create an abstracted layer to facilitate the use of [SkyHub API](http://www.skyhub.com.br) by PHP developers.

# Requirements

- PHP 5.6+
- PHP Multibyte String Extension installed and active
- PHP cURL extension installed and active

# How to Install

Install via composer:

	composer require glauberportella/skyhub-php

# Classes

The library has the following classes

### Exceptions

- \SkyHub\Exception\ForbiddenException
- \SkyHub\Exception\MalformedRequestException
- \SkyHub\Exception\MethodNotAllowedException
- \SkyHub\Exception\NotAcceptableException
- \SkyHub\Exception\NotFoundException
- \SkyHub\Exception\RequestException
- \SkyHub\Exception\SemanticalErrorException
- \SkyHub\Exception\SkyHubException
- \SkyHub\Exception\UnauthorizedException

### Handlers

- \SkyHub\Handlers\JsonHandler

### Requests

- \SkyHub\Request\AttributeRequest
- \SkyHub\Request\CategoryRequest
- \SkyHub\Request\OrderRequest
- \SkyHub\Request\OrderStatusRequest
- \SkyHub\Request\ProductRequest
- \SkyHub\Request\QueueRequest
- \SkyHub\Request\Request *&lt;abstract&gt;*
- \SkyHub\Request\RequestFactory
- \SkyHub\Request\RequestInterface *&lt;interface&gt;*
- \SkyHub\Request\SaleSystemRequest
- \SkyHub\Request\StatusTypeRequest

### Resources

- \SkyHub\Resource\ApiResource *&lt;abstract&gt;*
- \SkyHub\Resource\ApiResourceInterface *&lt;interface&gt;*
- \SkyHub\Resource\Attribute
- \SkyHub\Resource\Category
- \SkyHub\Resource\Order
- \SkyHub\Resource\OrderStatus
- \SkyHub\Resource\Product
- \SkyHub\Resource\SaleSystem
- \SkyHub\Resource\StatusType

### Security

- \SkyHub\Security\Auth

### Utils

- \SkyHub\Utils\JsonUtils - contains a safe json encoding routine, based on Multibyte String charset converter

# Documentation

Send an API request is simple, you create a Request object and call the RESTful methods supported by the [SkyHub API](http://in.skyhub.com.br/api-explorer/) with the required resource/code.

Below is some Product requests, the principle is the same for the other type of resources on the SkyHub API.

## Product Example

### 1. Get Registered Products

	<?php
	require_once dirname(__FILE__).'/vendor/autoload.php';

	// Every request needs an Auth
	$auth = new \SkyHub\Security\Auth('YOUR-API-EMAIL', 'YOUR-TOKEN');

	// The request object
	$request = new \SkyHub\Request\ProductRequest($auth);

	// Send a GET request
	$products = $request->get();

	// $products can be an array if more than one product is found or a \SkyHub\Resource\Product object.

## 2. Get one Product

	<?php
	require_once dirname(__FILE__).'/vendor/autoload.php';

	// Every request needs an Auth
	$auth = new \SkyHub\Security\Auth('YOUR-API-EMAIL', 'YOUR-TOKEN');

	// The request object
	$request = new \SkyHub\Request\ProductRequest($auth);

	try {
		// You can get by code
		$productCode = 'product-sku-code';
		// Or passing a resource \SkyHub\Resource\Product object
		// $obj = new \SkyHub\Resource\Product()
		// $obj->sku = 'sku-code';
		// $obj->name = 'My product';
		// ...
		// $product = $request->get($obj);

		// a \SkyHub\Resource\Product object
		$product = $request->get($productCode);
	} catch (\SkyHub\Exception\NotFoundException $e) {
		// product not found
	} catch (\SkyHub\Exception\SkyHubException $e) {
		// another exception was throw
	}

## 3. Create a new Product

	<?php
	require_once dirname(__FILE__).'/vendor/autoload.php';

	// Every request needs an Auth
	$auth = new \SkyHub\Security\Auth('YOUR-API-EMAIL', 'YOUR-TOKEN');

	// The request object
	$request = new \SkyHub\Request\ProductRequest($auth);

	$product = new Product();
	$product->sku = 'product-sku-code';
	$product->name = "Product name";
	$product->description = "Product description";
	$product->status = "enabled";
	$product->qty = 10;
	$product->price = 1000.50;
	$product->promotional_price = 850.50;
	$product->cost = 560.00;
	$product->weight = 5;
	$product->height = 15;
	$product->width = 30;
	$product->length = 15;
	$product->brand = "product-brand";
	$product->ean = "";
	$product->nbm = "";
	$product->categories = array(array (
		"code" => "category-code",
		"name" => "Category name"
	));
	$product->images = array(
		// Images URLs
		'http://lorempixel.com/600/400/'
	);
	$product->specifications = array(
		array(
			"key" 	=> "spec-key",
			"value" => "Spec value"
		),
	);
	$product->variations = array(
	    array(
	      	"sku" 			=> "sku-var-code",
	      	"qty" 			=>  5,
	      	"ean" 			=> "",
	      	"images" 			=> array(
	      		// Images URLs
	      		'http://lorempixel.com/600/400/'
	      	),
	      	"specifications" 	=> array(
	        	array(
	          		"key"   => "spec-var-key",
	          		"value" => "Spec value for variation"
	        	)
	      	)
	    )
	);
	$product->variation_attributes = array(
		"spec-var-attribute-key"
	);

	try {
		// send POST request
		$request->post($product);
	} catch (\SkyHub\Exception\RequestException $e) {
		// Some exception was throw
	}

## 4. Update a Product

	<?php
	require_once dirname(__FILE__).'/vendor/autoload.php';

	// Every request needs an Auth
	$auth = new \SkyHub\Security\Auth('YOUR-API-EMAIL', 'YOUR-TOKEN');

	// The request object
	$request = new \SkyHub\Request\ProductRequest($auth);

	$product = new Product();
	// Set the code sku to the "product to update" code
	$product->sku = 'product-sku-code';
	// Some property changes
	$product->name = 'Changed name';
	$product->quantity = 20;
	// ...

	try {
		// send PUT request
		$request->put($product);
	} catch (\SkyHub\Exception\RequestException $e) {
		// Some exception was throw
	}

# The Request Factory

For easy request creation or some runtime request creation you can use the \SkyHub\Request\RequestFactory class to create the request instances specific to a resource type.

	<?php
	require_once dirname(__FILE__).'/vendor/autoload.php';

	// Every request needs an Auth
	$auth = new \SkyHub\Security\Auth('YOUR-API-EMAIL', 'YOUR-TOKEN');

	// An Attribute request
	$attributeReq = \SkyHub\Request\RequestFactory::fromClassName('Attribute', $auth);

	// A Category request
	$categoryReq = \SkyHub\Request\RequestFactory::fromClassName('Category', $auth);

	// An Order request
	$orderReq = \SkyHub\Request\RequestFactory::fromClassName('Order', $auth);

	// An OrderStatus request (statuses)
	$orderStatusReq = \SkyHub\Request\RequestFactory::fromClassName('OrderStatus', $auth);

	// A Product request
	$productReq = \SkyHub\Request\RequestFactory::fromClassName('Product', $auth);

	// A SaleSystem request (sale_systems)
	$saleSystemReq = \SkyHub\Request\RequestFactory::fromClassName('SaleSystem', $auth);

	// A StatusType request (status_types)
	$statusTypeReq = \SkyHub\Request\RequestFactory::fromClassName('StatusType', $auth);

You can also use a Resource object instance to get the request object

	<?php
	require_once dirname(__FILE__).'/vendor/autoload.php';

	// Every request needs an Auth
	$auth = new \SkyHub\Security\Auth('YOUR-API-EMAIL', 'YOUR-TOKEN');

	// An Attribute request
	$attribute = new \SkyHub\Resource\Attribute();
	$attributeReq = \SkyHub\Request\RequestFactory::fromResource($attribute, $auth);

	// A Category request
	$category = new \SkyHub\Resource\Category();
	$categoryReq = \SkyHub\Request\RequestFactory::fromResource($category, $auth);

	// An Order request
	$order = new \SkyHub\Resource\Order();
	$orderReq = \SkyHub\Request\RequestFactory::fromResource($order, $auth);

	// An OrderStatus request (statuses)
	$orderStatus = new \SkyHub\Resource\OrderStatus();
	$orderStatusReq = \SkyHub\Request\RequestFactory::fromResource($orderStatus, $auth);

	// A Product request
	$product = new \SkyHub\Resource\Product();
	$productReq = \SkyHub\Request\RequestFactory::fromResource($product, $auth);

	// A SaleSystem request (sale_systems)
	$saleSystem = new \SkyHub\Resource\SaleSystem();
	$saleSystemReq = \SkyHub\Request\RequestFactory::fromResource($saleSystem, $auth);

	// A StatusType request (status_types)
	$statusType = new \SkyHub\Resource\StatusType();
	$statusTypeReq = \SkyHub\Request\RequestFactory::fromResource($statusType, $auth);

# TODO

1. Add others API resources
	- Questions
	- Sync Errors

# The MIT License (MIT)

Copyright (c) 2015 Glauber Portella <glauberportella@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.