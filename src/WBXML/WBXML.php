<?php
namespace YOCLIB\WBXML;

class WBXML{

	public const VERSION_1_0 = 0x00;
	public const VERSION_1_1 = 0x01;
	public const VERSION_1_2 = 0x02;
	public const VERSION_1_3 = 0x03;

	public const SWITCH_PAGE = 0x00;
	public const END = 0x01;
	public const ENTITY = 0x02;
	public const STR_I = 0x03;
	public const LITERAL = 0x04;
	public const EXT_I_0 = 0x40;
	public const EXT_I_1 = 0x41;
	public const EXT_I_2 = 0x42;
	public const PI = 0x43;
	public const LITERAL_C = 0x44;
	public const EXT_T_0 = 0x80;
	public const EXT_T_1 = 0x81;
	public const EXT_T_2 = 0x82;
	public const STR_T = 0x83;
	public const LITERAL_A = 0x84;
	public const EXT_0 = 0xC0;
	public const EXT_1 = 0xc1;
	public const EXT_2 = 0xC2;
	public const OPAQUE = 0xC3;
	public const LITERAL_AC = 0xC4;

	private $version;
	private $publicid;
	private $publicid_isIndex;
	private $charset;
	private $strtbl;
	private $body;

	public function getVersion(){
		return $this->version;
	}

	public function getPublicId(){
		return $this->publicid;
	}

	public function isIndex(){
		return $this->publicid_isIndex;
	}

	public function getCharset(){
		return $this->charset;
	}

	public function getStringTable(){
		return $this->strtbl;
	}

	public function getBody(){
		return $this->body;
	}

	/**
	 * @param $input
	 * @throws WBXMLException
	 */
	public function deserialize($input): void{
		$stream = fopen('data://text/plain;base64,'.base64_encode($input),'rb');
		$this->deserializeStream($stream);
		fclose($stream);
	}

	/**
	 * @param $stream
	 * @throws WBXMLException
	 */
	public function deserializeStream($stream): void{
		$version = $this->readByte($stream);
		if($version!==self::VERSION_1_0 && $version!==self::VERSION_1_1 && $version!==self::VERSION_1_2 && $version!==self::VERSION_1_3){
			throw new WBXMLException('Version not supported');
		}

		$publicid = $this->readMultibyteUnsignedInt($stream);
		$index = false;
		if($publicid===0){
			$index = $this->readMultibyteUnsignedInt($stream);
		}

		$charset = $this->readMultibyteUnsignedInt($stream);

		$length = $this->readMultibyteUnsignedInt($stream);
		$strtbl = [];
		for($i=0;$i<$length;$i++){
			$strtbl = $this->readByte($stream);
		}
		if($index){
			$publicid = $strtbl[$index];
		}

		$body = [];

		for($i=0;$i<2000;$i++){
			try{
				$b = $this->readByte($stream);
			}catch(WBXMLException $e){
				break;
			}

			$token = null;
			$content = null;

			switch($b){
				case 0x00:{
					$token = 'SWITCH_PAGE';
					try{
						$content = $this->readByte($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x01:{
					$token = 'END';
					break;
				}
				case 0x02:{
					$token = 'ENTITY';
					try{
						$content = $this->readMultibyteUnsignedInt($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x03:{
					$token = 'STR_I';
					try{
						$content = $this->readTerminatedString($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x04:{
					$token = 'LITERAL';
					try{
						$content = $this->readMultibyteUnsignedInt($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				##########################################
				case 0x40:{
					$token = 'EXT_I_0';
					try{
						$content = $this->readTerminatedString($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x41:{
					$token = 'EXT_I_1';
					try{
						$content = $this->readTerminatedString($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x42:{
					$token = 'EXT_I_2';try{
						$content = $this->readTerminatedString($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x43:{
					$token = 'PI';
					break;
				}
				case 0x44:{
					$token = 'LITERAL_C';
					break;
				}
				##########################################
				case 0x80:{
					$token = 'EXT_T_0';
					try{
						$content = $this->readMultibyteUnsignedInt($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x81:{
					$token = 'EXT_T_1';
					try{
						$content = $this->readMultibyteUnsignedInt($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x82:{
					$token = 'EXT_T_2';
					try{
						$content = $this->readMultibyteUnsignedInt($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x83:{
					$token = 'STR_T';
					try{
						$content = $this->readMultibyteUnsignedInt($stream);
					}catch(WBXMLException $e){

					}
					break;
				}
				case 0x84:{
					$token = 'LITERAL_A';
					break;
				}
				##########################################
				case 0xC0:{
					$token = 'EXT_0';
					break;
				}
				case 0xC1:{
					$token = 'EXT_1';
					break;
				}
				case 0xC2:{
					$token = 'EXT_2';
					break;
				}
				case 0xC3:{
					$token = 'OPAQUE';
					break;
				}
				case 0xC4:{
					$token = 'LITERAL_AC';
					break;
				}
			}

			$item = [
				'tag'				=> $b,
				'token'				=> $token,
				'has_attributes'	=> (bool) ($b>>7&0b1),
				'has_content'		=> (bool) ($b>>6&0b1),
				'tag_identity'		=> ($b&0b111111),
				'content'			=> $content,
			];

			$body[] = $item;
		}

		$this->version = $version;
		$this->publicid = $publicid;
		$this->publicid_isIndex = $index!==false;
		$this->charset = $charset;
		$this->strtbl = $strtbl;
		$this->body = $body;
	}

//	/**
//	 * @return string
//	 * @throws WBXMLException
//	 */
//	public function serialize(){
//		$stream = fopen('data://text/plain;base64,'.base64_encode($input),'rb');
//		return $this->serializeStream($stream);
//		$output = '';
//		if($this->version===null){
//			throw new WBXMLException('Version is null');
//		}
//		$output .= chr($this->version);
//
//		return $output;
//	}
//
//	/**
//	 * @return string
//	 * @throws WBXMLException
//	 */
//	public function serializeStream(){
//		$output = '';
//		if($this->version===null){
//			throw new WBXMLException('Version is null');
//		}
//		$output .= chr($this->version);
//
//		return $output;
//	}


	/**
	 * @param $stream
	 * @return int
	 * @throws WBXMLException
	 */
	protected function readMultibyteUnsignedInt($stream): int{
		$uInt = 0;

		do{
			$byte = $this->readByte($stream);
			$uInt <<= 7;
			$uInt += ($byte & 127);
		} while (($byte & 128) !== 0);

		return $uInt;
	}

	/**
	 * @param $stream
	 * @return int
	 * @throws WBXMLException
	 */
	protected function readByte($stream): int{
		$byte = fread($stream,1);

		if($byte==='' || $byte===false){
			throw new WBXMLException('Failed to read byte');
		}

		return ord($byte);
	}

	/**
	 * @param $stream
	 * @param $length
	 * @return string
	 * @throws WBXMLException
	 */
	protected function readOpaque($stream,$length): string{
		$string = fread($stream,$length);

		if($string===false){
			throw new WBXMLException('Failed to read opaque data');
		}

		return $string;
	}

	/**
	 * @param $stream
	 * @return string
	 * @throws WBXMLException
	 */
	protected function readTerminatedString($stream): string{
		$string = '';

		while(($byte = $this->readByte($stream))!==0){
			$string .= chr($byte);
		}

		return $string;
	}

	protected function writeByte($stream,$byte): void{
		fwrite($stream,chr($byte));
	}

	protected function writeMultiByteUnsignedInt($stream,$integer): void{
		$multibyte = NULL;
		$remainder = $integer;

		do{
			$byte = ($remainder & 127);
			$remainder >>= 7;
			if($multibyte===NULL){
				$multibyte = chr($byte);
			} else {
				$multibyte = chr($byte | 128).$multibyte;
			}
		} while($remainder!==0);

		fwrite($stream,$multibyte);
	}

	protected function writeString($stream,$string): void{
		fwrite($stream,$string);
	}

	protected function writeTerminatedString($stream,$string): void{
		fwrite($stream,$string);
		fwrite($stream,chr(0));
	}













}