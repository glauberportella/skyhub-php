<?php

namespace SkyHub\Request;

use SkyHub\Security\Auth;
use SkyHub\Resource\ApiResourceInterface;

class RequestFactory
{
	private static $map = array(
		'\SkyHub\Resource\Attribute' 	=> '\SkyHub\Request\AttributeRequest',
		'\SkyHub\Resource\Category' 	=> '\SkyHub\Request\CategoryRequest',
		'\SkyHub\Resource\Order' 		=> '\SkyHub\Request\OrderRequest',
		'\SkyHub\Resource\OrderStatus' 	=> '\SkyHub\Request\OrderStatusRequest',
		'\SkyHub\Resource\Product' 		=> '\SkyHub\Request\ProductRequest',
		'\SkyHub\Resource\SaleSystem'	=> '\SkyHub\Request\SaleSystemRequest',
		'\SkyHub\Resource\StatusType'	=> '\SkyHub\Request\StatusTypeRequest',

		'SkyHub\Resource\Attribute' 	=> '\SkyHub\Request\AttributeRequest',
		'SkyHub\Resource\Category' 		=> '\SkyHub\Request\CategoryRequest',
		'SkyHub\Resource\Order' 		=> '\SkyHub\Request\OrderRequest',
		'SkyHub\Resource\OrderStatus' 	=> '\SkyHub\Request\OrderStatusRequest',
		'SkyHub\Resource\Product' 		=> '\SkyHub\Request\ProductRequest',
		'SkyHub\Resource\SaleSystem'	=> '\SkyHub\Request\SaleSystemRequest',
		'SkyHub\Resource\StatusType'	=> '\SkyHub\Request\StatusTypeRequest',

		'Attribute' 	=> '\SkyHub\Request\AttributeRequest',
		'Category' 		=> '\SkyHub\Request\CategoryRequest',
		'Order' 		=> '\SkyHub\Request\OrderRequest',
		'OrderStatus' 	=> '\SkyHub\Request\OrderStatusRequest',
		'Product' 		=> '\SkyHub\Request\ProductRequest',
		'SaleSystem' 		=> '\SkyHub\Request\SaleSystemRequest',
		'StatusType' 		=> '\SkyHub\Request\StatusTypeRequest',
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