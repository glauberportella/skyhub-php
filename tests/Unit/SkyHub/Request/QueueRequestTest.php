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

	public function testQueueRequestDelete()
	{
		// prepare mock
		$queue = $this->getMockBuilder('\SkyHub\Request\QueueRequest')
			->setConstructorArgs(array($this->auth))
			->getMock();
		$fakeOrder = new \SkyHub\Resource\Order();
		$fakeOrder->code = 'Submarino-123456789000';
		$queue->method('orders')->willReturn($fakeOrder);
		$queue->method('delete')
			->with($this->equalTo('Submarino-123456789000'))
			->willReturn(true);

		$orders = $queue->orders();
		$this->assertInstanceOf('\SkyHub\Resource\Order', $orders);

		$queue->delete($orders->code);
		$fromQueue = $queue->orders();
		file_put_contents(dirname(__FILE__).'/../../../data/queue-delete.log', json_encode($fromQueue, JSON_PRETTY_PRINT));
		$this->assertTrue(true);
	}
}