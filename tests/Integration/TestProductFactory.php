<?php
namespace Tests\Integration;

use SkyHub\Resource\Product;

final class TestProductFactory
{
	static public function factory()
	{
		$ts = time();
		$sku = "sku-$ts";

		$product = new Product();
		$product->sku = $sku;
		$product->name = "Produto de teste skyhub-php";
		$product->description = "Teste lib PHP para API SkyHub";
		$product->status = "enabled";
		$product->qty = 10;
		$product->price = 1000.50;
		$product->promotional_price = 850.50;
		$product->cost = 0;
		$product->weight = 5;
		$product->height = 15;
		$product->width = 30;
		$product->length = 15;
		$product->brand = "skyhub-php";
		$product->ean = "";
		$product->nbm = "";
		$product->categories = array(array (
		  "code" => "skyhub-php_123456",
		  "name" => "CatTeste_skyhub-php"
		));
		$product->images = array(
			'http://lorempixel.com/600/400/'
		);
		$product->specifications = array(
			array(
				"key" 	=> "Specification-test123",
				"value" => "Test skyhub-php lib"
			),
		);
		$product->variations = array(
		    array(
		      	"sku" 			=> "$sku-var",
		      	"qty" 			=>  5,
		      	"ean" 			=> "",
		      	"images" 			=> array(
		      		'http://lorempixel.com/600/400/'
		      	),
		      	"specifications" 	=> array(
		        	array(
		          		"key"   => "Specification-var-test123",
		          		"value" => "Test skyhub-php lib spec variation"
		        	)
		      	)
		    )
		);
		$product->variation_attributes = array(
			"Specification-var-test123"
		);

		return $product;
	}
}