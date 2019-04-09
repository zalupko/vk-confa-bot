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
		$this->event = $event;
	}

	public function getEvent()
	{
		return $this->event;
	}

	public function getCallbackToken()
	{
		return $this->callbackToken;
	}

	public function eventToModule()
	{
		
	}
}
