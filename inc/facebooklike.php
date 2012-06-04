<?php

Class FacebookLike extends SocialButtonAbstract{
	const FB_SEND = 'fb:send';
	const FB_HREF = 'fb:href';
	const FB_WIDTH = 'fb:width';
	const FB_LAYOUT = 'fb:layout';
	const FB_SHOW_FACES = 'fb:show-faces';
	const FB_ACTION = 'fb:action';
	const FB_FONT = 'fb:font';
	const FB_COLORSCHEME = 'fb:colorscheme';
	const FB_REF = 'fb:ref';
	
	private $_apyKey = null;

	
	protected $settings = array(
			self::FB_SEND => 'true',//Display button SEND
			self::FB_HREF => FALSE,//the URL to like. If FALSE defaults to the current page.
			self::FB_WIDTH => '88',// the width of the Like button.
			self::FB_LAYOUT => "button_count", //there are three options standard, button_count and box_count
			self::FB_SHOW_FACES => 'false', //specifies whether to display profile photos below the button (standard layout only)
			self::FB_ACTION => 'like',//the verb to display on the button. Options: 'like', 'recommend',
			self::FB_FONT => FALSE,//the font to display in the button. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
			self::FB_COLORSCHEME => 'light',// the color scheme for the like button. Options: 'light', 'dark'
			self::FB_REF => FALSE// I don't understend how this works, for now is a Todo
	);
	
	public function setApiKey($apyKey){
		$this->_apyKey = $apyKey; 
	}


	public function renderScript(){
		$apiKey = $this->_apyKey;
		if ($apiKey !== null){
			$apiKey = "&appId=$apiKey";
		}else{
			$apiKey = '';
		}
		$markup = <<<HTML
<div id="fb-root"></div>
<script>
(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1$apiKey";
		fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

HTML;
		return $markup;
	}

	public function renderButton(array $settings = null){
		$this->_mergeSettings($settings);
		$dataAttributes = array();
		foreach ($this->settings as $attr => $value){
			//Skip the values thatare FALSE, no need to render anything for them
			if($value === FALSE){
				continue;
			}
			//convert the keys from the format fb:send to the HTML5 data-send
			$attr = str_replace("fb:", "data-", $attr);
			$dataAttributes[$attr] = $value;
		}
		
		$markup = "<div class=\"fb-like\" ";
		foreach ($dataAttributes as $dataAttr => $dataValue){
			$markup .= "$dataAttr=\"$dataValue\" ";
		}
		$markup .= "></div>";
		return $markup;
	}

}