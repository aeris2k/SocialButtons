<?php

class TwitterButton extends SocialButtonAbstract{
	const TWEETER_URL = 'tweeter:url';
	const TWEETER_VIA = 'tweeter:via';
	const TWEETER_TEXT = 'tweeter:text';
	const TWEETER_RELATED = 'tweeter:related';
	const TWEETER_COUNT = 'tweeter:count';
	const TWEETER_LANG = 'tweeter:lang';
	const TWEETER_HASHTAGS = 'tweeter:hashtags';
	const TWEETER_SIZE = 'tweeter:size';
	const TWEETER_COUNTURL = 'tweeter:counturl';
	
	protected $settings = array(
			self::TWEETER_URL => FALSE,//URL to Tweet (Defaults to HTTP Referrer)
			self::TWEETER_VIA => 'BiagettiStudio',//via user (no default)
			self::TWEETER_TEXT => FALSE,//Tweet text (Defaults to the content of the <title> tag)
			self::TWEETER_RELATED => FALSE,//Recommended accounts
			self::TWEETER_COUNT => 'none',//Count box position (Defaults to 'horizontal'), it can also be 'none' or 'vertical'
			self::TWEETER_LANG => 'en',//Language (Defaults to 'en')
			self::TWEETER_HASHTAGS => FALSE,//Hashtags to include
			self::TWEETER_SIZE => FALSE,//the width of the button it can be medium or large (Defaults to medium)
			self::TWEETER_COUNTURL => FALSE//URL to which your shared URL resolves (only if you share short urls)
	);
	
	public function renderScript(){
		$markup = <<<HTML
<script>
!function(d,s,id){
		var js,fjs=d.getElementsByTagName(s)[0];
		if(!d.getElementById(id)){js=d.createElement(s);
		js.id=id;
		js.src="//platform.twitter.com/widgets.js";
		fjs.parentNode.insertBefore(js,fjs);
	}
}(document,"script","twitter-wjs");
</script>
HTML;
		return $markup;
	}
	
	public function renderButton(array $settings = NULL){
		$this->_mergeSettings($settings);
		$dataAttributes = array();
		foreach ($this->settings as $attr => $value){
			//Skip the values thatare FALSE, no need to render anything for them
			if($value === FALSE){
				continue;
			}
			//convert the keys from the format fb:send to the HTML5 data-send
			$attr = str_replace("tweeter:", "data-", $attr);
			$dataAttributes[$attr] = $value;
		}
	
		$markup = "<a href=\"https://twitter.com/share\" class=\"twitter-share-button\" ";
		foreach ($dataAttributes as $dataAttr => $dataValue){
			$markup .= "$dataAttr=\"$dataValue\" ";
		}
		$markup .= ">Tweet</a>";
		return $markup;
	}
	
	
}