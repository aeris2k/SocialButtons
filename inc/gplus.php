<?php

class Gplus extends SocialButtonAbstract {
	const GPLUS_HREF = 'gplus:href';
	const GPLUS_SIZE = 'gplus:size';
	const GPLUS_ANNOTATION = 'gplus:annotation';
	const GPLUS_WIDTH = 'gplus:width';

	
	
	protected $settings = array(
			self::GPLUS_HREF => FALSE,//The href to +1, defaults to the current URL
			self::GPLUS_SIZE => 'medium',//The size of the button 'small' (15px) 'standard' (24px)  'medium' (20px) 'tall' (60px)
			self::GPLUS_ANNOTATION => 'bubble',// The annotation to display next to the button. can be 'none', 'bubble' or 'inline'
			self::GPLUS_WIDTH => FALSE//the width of the +1 if the annotation is 'inline
	);
	
	public function renderScript(){
		$markup = <<<HTML
<script type="text/javascript">
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
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
			$attr = str_replace("gplus:", "data-", $attr);
			$dataAttributes[$attr] = $value;
		}
	
		$markup = "<div class=\"g-plusone\" ";
		foreach ($dataAttributes as $dataAttr => $dataValue){
			$markup .= "$dataAttr=\"$dataValue\" ";
		}
		$markup .= "></div>";
		return $markup;
	}
	
}