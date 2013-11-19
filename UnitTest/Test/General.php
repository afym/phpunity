<?php

namespace Test;

use Config\PHPUnit;

class General extends PHPUnit
{
	private static $objects;

	public static function setUpBeforeClass()
	{
		self::$objects = new \ArrayObject();
	}

	public function testCountOutput()
	{
		
	}
}