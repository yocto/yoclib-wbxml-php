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

	/**
	 * @param string $input
	 * @param int $version
	 * @return string|null
	 * @throws WBXMLException
	 */
	public function encode(string $input,$version=0x03): ?string{
		$wbxml = new WBXML;
		$wbxml->setVersion($version);
		$wbxml->setPublicId(0x01);
		$wbxml->setIsIndex(false);
		$wbxml->setCharset(0x6A);
		$wbxml->setStringTable([]);

		$xml = new DOMDocument($input);

		//TODO Body
		$wbxml->setBody([]);

		return $wbxml->serialize();
	}

	/**
	 * @param $stream
	 * @return string|null
	 * @throws WBXMLException
	 */
	public function encodeStream($stream): ?string{
		return $this->encode(stream_get_contents($stream));
	}

}