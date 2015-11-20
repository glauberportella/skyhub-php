<?php

namespace GlauberPortella\SkyHub\Request;

use GlauberPortella\SkyHub\Security\Auth;
use GlauberPortella\SkyHub\Resource\ApiResourceInterface;

class RequestFactory
{
	/**
	 * @var \GlauberPortella\SkyHub\Security\Auth
	 */
	protected $auth;

	/**
	 * @var RequestFactory instance
	 */
	static protected $factory;

	private function __construct(Auth $auth)
	{
		$this->auth = $auth;
	}

	static public function create(Auth $auth)
	{
		self::$factory = new RequestFactory($auth);
		return self::$factory;
	}

	public function forResource(ApiResourceInterface $resource)
	{
		$requestClassname = get_class($resource);
		return new $requestClassname($this->auth);
	}

}