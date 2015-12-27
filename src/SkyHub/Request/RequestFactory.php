<?php

namespace GlauberPortella\SkyHub\Request;

use GlauberPortella\SkyHub\Security\Auth;
use GlauberPortella\SkyHub\Resource\ApiResourceInterface;

class RequestFactory
{
	private static $map = array(
		'\GlauberPortella\SkyHub\Resource\Attribute' 	=> '\GlauberPortella\SkyHub\Request\AttributeRequest',
		'\GlauberPortella\SkyHub\Resource\Category' 	=> '\GlauberPortella\SkyHub\Request\CategoryRequest',
		'\GlauberPortella\SkyHub\Resource\Order' 		=> '\GlauberPortella\SkyHub\Request\OrderRequest',
		'\GlauberPortella\SkyHub\Resource\OrderStatus' 	=> '\GlauberPortella\SkyHub\Request\OrderStatusRequest',
		'\GlauberPortella\SkyHub\Resource\Product' 		=> '\GlauberPortella\SkyHub\Request\ProductRequest',

		'GlauberPortella\SkyHub\Resource\Attribute' 	=> '\GlauberPortella\SkyHub\Request\AttributeRequest',
		'GlauberPortella\SkyHub\Resource\Category' 		=> '\GlauberPortella\SkyHub\Request\CategoryRequest',
		'GlauberPortella\SkyHub\Resource\Order' 		=> '\GlauberPortella\SkyHub\Request\OrderRequest',
		'GlauberPortella\SkyHub\Resource\OrderStatus' 	=> '\GlauberPortella\SkyHub\Request\OrderStatusRequest',
		'GlauberPortella\SkyHub\Resource\Product' 		=> '\GlauberPortella\SkyHub\Request\ProductRequest',

		'Attribute' 	=> '\GlauberPortella\SkyHub\Request\AttributeRequest',
		'Category' 		=> '\GlauberPortella\SkyHub\Request\CategoryRequest',
		'Order' 		=> '\GlauberPortella\SkyHub\Request\OrderRequest',
		'OrderStatus' 	=> '\GlauberPortella\SkyHub\Request\OrderStatusRequest',
		'Product' 		=> '\GlauberPortella\SkyHub\Request\ProductRequest',
	);

	static public function fromClassName($className, Auth $auth)
	{
		return new $className($auth);
	}

	static public function fromResource(ApiResourceInterface $resource, Auth $auth)
	{
		$resourceClassname = get_class($resource);
		return self::fromClassName(self::$map[$resourceClassname], $auth);
	}
}