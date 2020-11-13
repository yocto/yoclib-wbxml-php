<?php
namespace YOCLIB\WBXML;

class WBXMLCodePage{

	private $number;
	private $codes;
	private $namespace;
	private $prefix;

	public function __construct(int $number=0,array $codes=[],$namespace=null,$prefix=null){
		$this->number = $number;
		$this->codes = $codes;
		$this->namespace = $namespace;
		$this->prefix = $prefix;
	}

	public function getNumber(){
		return $this->number;
	}

	public function getNamespace(){
		return $this->namespace;
	}

	public function getPrefix(){
		return $this->prefix;
	}

	public function getCodes(){
		return $this->codes;
	}

}