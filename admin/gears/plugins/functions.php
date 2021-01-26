<?php

	function get_plugins(){
		global $links;
		
		$plugins = scandir($links['plugins']);	
		$pluginsFolderSize = count($plugins) - 1;

		for($i = 2; $i <= $pluginsFolderSize; $i++){

			if(strpos($plugins[$i], '.disabled') !== false){
				$pluginStatus = 'disabled';
			}
			else{
				$pluginStatus = 'enabled';
			}

			echo '<div id="'.str_replace('.disabled', '', $plugins[$i]).'" class="plugin-container" class="plugin '.$pluginStatus.'">
				<img src="http:/'.'/cms/content/plugins/'.$plugins[$i].'/preview.png" class="plugin-preview"/>
				<ul class="plugin-infos">';

			$infos = fopen($links['plugins'].$plugins[$i].'/infos.txt','r');
			while(! feof($infos))  {
				$line = fgets($infos);
				echo '<li>'.$line.'</li>';
			}
			fclose($infos);
				echo '</ul>
				<button class="float-right">';
				
				if($pluginStatus == 'enabled'){
					echo 'Desactivate';
				}
				else if($pluginStatus == 'disabled'){
					echo 'Activate';
				}
				
				echo '</button>
			</div>';
		}
	}