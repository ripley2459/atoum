<?php

	function get_plugins_wrapper(){
		global $LINKS, $THEME;
		$plugins = scandir($LINKS['PLUGINS']);	
		$plugins_folder_size = count($plugins) - 1;
		$to_display = '';

		for($i = 2; $i <= $plugins_folder_size; $i++){
			if($plugins[$i] == $THEME){
				$this_plugin_is = 'enabled';
			}
			else{
				$this_plugin_is = 'disabled';
			}
			$to_display = $to_display . 
			get_block_div(
				get_block_link('plugins.php?switch_to_theme=' . $plugins[$i], 
					get_block_image($LINKS['PLUGINS'] . $plugins[$i] . '/screenshot.png', '', 'theme-screenshot', 'template') . 
					get_block_div('INFOS', '', 'theme-infos', 'template')
				, '', '', '', 'template')
			, '', 'theme ' . $this_plugin_is, 'template');
		}
		return $to_display;
	}