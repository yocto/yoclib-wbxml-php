<?php
namespace YOCLIB\WBXML;

class WBXMLDecoder{

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
	 * @return string|null
	 * @throws WBXMLException
	 */
	public function decode(string $input): ?string{
		$stream = fopen('data://text/plain;base64,'.base64_encode($input),'rb');
		return $this->decodeStream($stream);
	}

	/**
	 * @param $stream
	 * @return string|null
	 * @throws WBXMLException
	 */
	public function decodeStream($stream): ?string{
		$output = '';

		$wbxml = new WBXML;
		$wbxml->deserializeStream($stream);

		$body = $wbxml->getBody();
		$amount = count($body);
		$page = 0;

		$firstElement = true;

		$elements = [];
//		$hasSwitchedPage = true;

		$switches = [0];
		foreach($body AS $item){
			if($item['token']==='SWITCH_PAGE'){
				$switches[] = $item['content'];
			}
		}
		$switches = array_unique($switches);

		for($i=0;$i<$amount;$i++){
			$item = $body[$i];

			if($item['token']==='SWITCH_PAGE'){
				$page = $item['content'];
				//dump('SWITCH_PAGE','<->','----------------------------------------------------------');
//				$hasSwitchedPage = true;
				continue;
			}
			if($item['token']==='STR_I'){
				$append = $item['content'];
				//dump('STR_I',$append,$item,'----------------------------------------------------------');
				$output .= $append;
				continue;
			}
			if($item['token']==='END'){
				$name = array_pop($elements);
				//dump($name,$elements,'-----------------------------------------------------');
				$append = '</'.$name.'>';
				//dump('END',$append,'----------------------------------------------------------');
				$output .= $append;
				continue;
			}
			if($item['token']===null){
				$CP = $this->codepages[$page];
				$prefix = $CP->getPrefix();
				$tagName = $CP->getCode($item['tag_identity']);
				$name = (($prefix)?$prefix.':':'').$tagName;
				//if($name==='airsyncbase:EstimatedDataSize')dump($body[$i+1]);
				$append = '<'.$name.'';
				array_push($elements,$name);
				//dump($name,$elements,'-----------------------------------------------------');
				//$append .= '{'.$page.':'.$item['tag_identity'].'}';
				if($firstElement){
					foreach($switches AS $switch){
						$SWITCH_PAGE = $this->codepages[$switch];
						$prefix = $SWITCH_PAGE->getPrefix();
						$namespace = $SWITCH_PAGE->getNamespace();

						$append .= ' xmlns'.($prefix?':'.$prefix:'').'="'.($namespace ?? '').'"';
					}
					$firstElement = false;
				}
				if($item['has_attributes']){
					$append .= ' testAttr="testVal"';
				}
				if(!$item['has_content']){
					$append .= '/';
					array_pop($elements);
				}
				$append .= '>';
				//dump('NULL',$append,'----------------------------------------------------------');
				$output .= $append;
				continue;
			}
		}
		return $output;
	}

}