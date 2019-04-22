<?php
namespace Core\Utils;

class RuntimeTracker
{
	const FILENAME = 'runtime.txt';
	const RUNTIME_ERROR = 'Already in use';

	public static function checkIdentifier()
	{
		$time = (int)time();
		$identifier = file_get_contents(self::FILENAME);
		if ($identifier === false) {
			file_put_contents(self::FILENAME, $time);
			$identifier = $time;
		}
		if ($time != $identifier) {
			throw new \Exception(self::RUNTIME_ERROR);
		}
	}

	public static function removeIdentifier()
	{
		unlink(self::FILENAME);
	}
}
