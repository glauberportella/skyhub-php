<?php

namespace Tests\Unit\SkyHub\Request;

class QueueRequestTest extends \PHPUnit_Framework_TestCase
{
	private $auth;

	public function setUp()
	{
		$this->auth = new \SkyHub\Security\Auth(SKYHUB_EMAIL, SKYHUB_TOKEN);
	}

	public function testQueueRequestSuccessfully()
	{
		$actual = new \SkyHub\Request\QueueRequest($this->auth);
		$this->assertInstanceOf('\SkyHub\Request\QueueRequest', $actual);
	}

	public function testQueueRequestGet()
	{
		$queue = new \SkyHub\Request\QueueRequest($this->auth);
		$orders = $queue->orders();
		file_put_contents(dirname(__FILE__).'/../../../data/queue.log', json_encode($orders, JSON_PRETTY_PRINT));
		$this->assertTrue(true);
	}
}