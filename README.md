# yocLib - WBXML (PHP)

This yocLibrary enables your project to encode and decode WBXML data in PHP.

## Status

[![Build Status](https://travis-ci.com/yocto/yoclib-wbxml-php.svg?branch=master)](https://travis-ci.com/yocto/yoclib-wbxml-php)

## Installation

`composer require yocto/yoclib-wbxml`

## Use

### Encoding

```php
use YOCLIB\WBXML\CodePages\ExchangeActiveSync;
use YOCLIB\WBXML\WBXMLEncoder;
use YOCLIB\WBXML\WBXMLException;

$xml = '<FolderSync/>';

$codePages = ExchangeActiveSync::getCodePages();

$encoder = new WBXMLEncoder($codePages);

try{
	$binary = $encoder->encode($xml);
}catch(WBXMLException $e){
	//TODO
}
```

## Decoding

```php
use YOCLIB\WBXML\CodePages\ExchangeActiveSync;
use YOCLIB\WBXML\WBXMLDecoder;
use YOCLIB\WBXML\WBXMLException;

$binary = "\x03\x01\x6a\x00\x00\xff\xff";

$codePages = ExchangeActiveSync::getCodePages();

$decoder = new WBXMLDecoder($codePages);

try{
	$xml = $decoder->decode($binary);
}catch(WBXMLException $e){
	//TODO
}
```