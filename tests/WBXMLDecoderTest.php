<?php
namespace YOCLIB\WBXML\Tests;

use PHPUnit\Framework\TestCase;

use YOCLIB\WBXML\WBXMLDecoder;

class WBXMLDecoderTest extends TestCase{

	public function test__construct(){
		self::assertNotNull(new WBXMLDecoder([]));
	}

}