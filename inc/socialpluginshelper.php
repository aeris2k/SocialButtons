<?php

class SocialPluginsHelper {

	const ID_OF_WRAPPER = 'id_of_wrapper';
	const CLASS_OF_WRAPPERS = 'class_of_wrappers';
	const HTML_BEFORE_BUTTONS = 'html_before_buttons';
	const HTML_AFTER_BUTTONS = 'html_after_buttons';
	const CUSTOM_PLUGIN_STYLE = 'custom_plugin_style';
	const TAG_OF_WRAPPER = 'tag_of_wrapper';
	const STYLE_OF_WRAPPER = 'style_of_wrapper';

	function __construct(array $settings = null) {
		if ($settings !== null){
			$this->settings = array_merge($this->settings, $settings);
		}
	}

	private function createStyleAttribute($style){
		$customStyle = '';
		if(!empty($style)){
			$customStyle = "style=\"$style\"";
		}
		return $customStyle;
	}

	private $plugins = array();
	private $settings = array(
			self::ID_OF_WRAPPER => "socialButtons",//id of the wrapper element
			self::TAG_OF_WRAPPER => "div",//what HTML element to use as a wrapper, either DIV or UL (if you choose DIV, alle the children will be DIV too otherwise the will be LI)
			self::CLASS_OF_WRAPPERS => "social",//Class of the children element
			self::HTML_BEFORE_BUTTONS => '',//custom HTML before the plugins
			self::HTML_AFTER_BUTTONS => '',//custom HTML after the plugins
			self::STYLE_OF_WRAPPER => '',//custom style of the main wrapping element
			self::CUSTOM_PLUGIN_STYLE => array()//this is some custom style thatwill be added to the elements that surround the plugins, useful to add extra width or inline options. It's										  //an associative array  with the keys that equals the name of the classes (for example to add style to the Facebook plugin, use the key FacebookLike
	);

	public function add(SocialButtonAbstract $plugin){
		$this->plugins [] = $plugin;
	}

	public function renderAllButtons(array $pluginSettings = null){
		$settings = $this->settings;
		$tagOfChildren = $settings[self::TAG_OF_WRAPPER] === "div" ? "div" : "li";
		$tagOfWrapper = $settings[self::TAG_OF_WRAPPER];
		$idOfWrapper = $settings[self::ID_OF_WRAPPER];
		$htmlBeforeButtons = $settings[self::HTML_BEFORE_BUTTONS];
		$classOfWrappers = $settings[self::CLASS_OF_WRAPPERS];
		$htmlAfterButtons = $settings[self::HTML_AFTER_BUTTONS];
		$customStyleOfWrapper = $this->createStyleAttribute($settings[self::STYLE_OF_WRAPPER]);
		$markup = "<$tagOfWrapper $customStyleOfWrapper id=\"$idOfWrapper\">\n";
		$markup .= "$htmlBeforeButtons\n";
		foreach($this->plugins as $plugin){
			$customSettings = isset($pluginSettings[get_class($plugin)]) && is_array($pluginSettings[get_class($plugin)]) ? $pluginSettings[get_class($plugin)] : array();
			$customStyle = isset($settings[self::CUSTOM_PLUGIN_STYLE][get_class($plugin)]) ? $this->createStyleAttribute($settings[self::CUSTOM_PLUGIN_STYLE][get_class($plugin)]) : '';
			$markup .= "<$tagOfChildren class=\"$classOfWrappers\" $customStyle>".$plugin->renderButton($customSettings)."</$tagOfChildren>\n";
		}
		$markup .= "$htmlAfterButtons\n</$tagOfWrapper>\n";
		echo $markup;
	}

	public function renderAllScripts(){
		foreach($this->plugins as $plugin){
			echo $plugin->renderScript();
		}
	}



}
