<?php
namespace YOCLIB\WBXML\Tests;

use PHPUnit\Framework\TestCase;

use YOCLIB\WBXML\WBXMLEncoder;

class WBXMLEncoderTest extends TestCase{

	public function test__construct(){
		self::assertNotNull(new WBXMLEncoder([]));
	}

}