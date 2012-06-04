<?php

class PluginFactory {

	static public function create($plugin, array $settings = array()){
		return new $plugin($settings);
	}
}