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
		return new DOMDocument($input);
	}

	public function encodeStream($stream): ?string{
		return $this->encode(stream_get_contents($stream));
	}

}