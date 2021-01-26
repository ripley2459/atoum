<?php

	function get_themes(){
		global $links, $option_value, $THEME;
		
		$themes = scandir($links['themes']);	
		$themes_folder_size = count($themes) - 1;

		for($i = 2; $i <= $themes_folder_size; $i++){
			
			if($themes[$i] == $THEME){
				$this_theme_is = 'activated';
			}
			else{
				$this_theme_is = 'disabled';
			}
			
			echo '<div class="theme '.$this_theme_is.'"><a href="themes.php?switch_to_theme='.$themes[$i].'">
				<img src="http:/'.'/cms/content/themes/'.$themes[$i].'/preview.png" class="theme-preview"/>
				<div class="theme-infos">';

			$infos = fopen($links['themes'].$themes[$i].'/infos.txt','r');
			while(!feof($infos))  {
				$line = fgets($infos);
				
				if(strpos($line, 'Name:')!== false){
					echo '<h3>'.str_replace('Name: ','', $line).'</h3>';
				}
				
				//echo '<li>'.$line.'</li>';
			}
			fclose($infos);
				echo '</div>';

				if($this_theme_is == 'activated'){
						//echo '<a href="#">Deactivate<a>';
					}
			echo '</a></div>';
		}
	}