<?php
namespace YOCLIB\WBXML;

use DOMDocument;

class WBXMLEncoder{

	private $codepages;

	/**
	 * WBXMLDecoder constructor.
	 * @param WBXMLCodePage[] $codepages
	 */
	public function __construct(array $codepages){
		$this->codepages = $codepages;
	}

	public function encode(string $input): ?string{
		$wbxml = new WBXML;

		return new DOMDocument($input);

		return $wbxml->serialize();
	}

	public function encodeStream($stream): ?string{
		return $this->encode(stream_get_contents($stream));
	}

}