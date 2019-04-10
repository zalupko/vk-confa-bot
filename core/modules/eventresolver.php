<?php
class EventResolver
{
	const CALLBACK_API_EVENT_CONFIRMATION = '';
	private $event;
	private $callbackToken;

	public function __construct($callbackToken)
	{
		$this->callbackToken = $callbackToken;
	}

	public function receiveEvent()
	{
		$event = json_decode(file_get_contents('php://input'));
		$this->event = new Event($event);
		$this->sendResponse();
	}

	public function getEvent()
	{
		return $this->event;
	}

	public function getCallbackToken()
	{
		return $this->callbackToken;
	}
	
	public function sendResponse()
	{
		//Согласно VK API
		echo 'ok';
	}
}

class Event
{
	private $event;
	
	public function __construct($event)
	{
		// @TODO: Переработать согласно VK API
		$this->event = $event;
	}
	
	public function getEvent()
	{
		return $this->event;
	}
}