<?php

abstract class SocialButtonAbstract {
	protected $settings;
	final function __construct(array $settings = null) {
		$this->_mergeSettings($settings);
	}
	
	protected function _mergeSettings(array $settings){
		if ($settings !== null){
			$this->settings = array_merge($this->settings, $settings);
		}
	}
	
	abstract public function renderButton(array $settings = NULL);
	abstract public function renderScript();
}