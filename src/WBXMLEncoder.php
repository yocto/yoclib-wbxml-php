<?php
namespace YOCLIB\WBXML;

use DOMDocument;
use DOMNode;

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
	 */
	public function encode(string $input,$version=0x03): ?string{
		$wbxml = new WBXML;
		$wbxml->setVersion($version);
		$wbxml->setPublicId(0x01);
		$wbxml->setIsIndex(false);
		$wbxml->setCharset(0x6A);
		$wbxml->setStringTable([]);

		$xml = new DOMDocument();
		$xml->loadXML($input);
		$arr = $this->xmlToArray($xml->firstChild,$this->codepages);

		$wbxml->setBody($arr);

		return $wbxml->serialize();
	}

	/**
	 * @param $stream
	 * @return string|null
	 */
	public function encodeStream($stream): ?string{
		return $this->encode(stream_get_contents($stream));
	}

	private function xmlToArray(DOMNode $node,$codepages): array{
		$arr = [];

		if($node->hasChildNodes()){
			$arr[] = [null,$this->getTagId($node,$codepages),'OPEN'];
//			if($node->hasAttributes()){
//				//TODO Attributes
//			}
			foreach($node->childNodes AS $childNode){
				$addArr = $this->xmlToArray($childNode,$codepages);
				foreach($addArr AS $add){
					$arr[] = $add;
				}
			}
			$arr[] = [WBXML::END];
		}else{
			if($node->nodeType===XML_TEXT_NODE){
				$arr[] = [WBXML::STR_I,$node->nodeValue];
			}else{
				$arr[] = [null,$this->getTagId($node,$codepages),'SELF'];
//				if($node->hasAttributes()){
//					//TODO Attributes
//				}
			}
		}

		return $arr;
	}

	private function getTagId($node,$codepages){
		return 0xFF;
	}

}