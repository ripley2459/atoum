<?php

	function get_plugins(){
		global $LINKS;
		
		$plugins = scandir($LINKS['PLUGINS']);	
		$plugins_folder_size = count($plugins) - 1;

		for($i = 2; $i <= $plugins_folder_size; $i++){
			
			if(strpos($plugins[$i], '.disabled') !== false){
				$this_plugin_is = 'disabled';
			}
			else{
				$this_plugin_is = 'enabled';
			}
			
			echo '<div class="plugin '.$this_plugin_is.'"><a href="plugins.php?switch_to_plugin='.$plugins[$i].'">
				<img src="http:/'.'/cms/content/plugins/'.$plugins[$i].'/preview.png" class="plugin-preview"/>
				<div class="plugin-infos">';

			$infos = fopen($LINKS['PLUGINS'].$plugins[$i].'/infos.txt','r');
			while(!feof($infos))  {
				$line = fgets($infos);
				
				if(strpos($line, 'Name:')!== false){
					echo '<h3>'.str_replace('Name: ','', $line).'</h3>';
				}
				
				//echo '<li>'.$line.'</li>';
			}
			fclose($infos);
				echo '</div>';

				if($this_plugin_is == 'activated'){
						//echo '<a href="#">Deactivate<a>';
					}
			echo '</a></div>';
		}
	}