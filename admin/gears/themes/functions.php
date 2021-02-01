<?php

	function get_themes_wrapper(){
		global $LINKS, $THEME;
		$themes = scandir($LINKS['THEMES']);	
		$themes_folder_size = count($themes) - 1;
		$to_display = '';
		$theme_infos = array();

		for($i = 2; $i <= $themes_folder_size; $i++){
			$theme_infos = '';
			if($themes[$i] == $THEME){
				$this_theme_is = 'enabled';
			}
			else{
				$this_theme_is = 'disabled';
			}

 			$infos = fopen($LINKS['THEMES'] . $themes[$i] . '/infos.txt', 'r');
			while(!feof($infos)){
				$line = fgets($infos);
				if(strpos($line, 'name:')!== false){
					str_replace('name: ', '', $line);
					echo $line;
					$theme_infos = array('name' => $line);
				}
				if(strpos($line, 'url:')!== false){
					str_replace('url: ', '', $line);
					$theme_infos = array('url' => $line);
				}
				if(strpos($line, 'author:')!== false){
					$theme_infos = array("author" => str_replace('author:', '', $line));
				}
				if(strpos($line, 'author url:')!== false){
					$theme_infos = array("author_url" => str_replace('author url:', '', $line));
				}
				if(strpos($line, 'version:')!== false){
					$theme_infos = array("version" => str_replace('version:', '', $line));
				}
				if(strpos($line, 'version date:')!== false){
					$theme_infos = array("version_url" => str_replace('version date:', '', $line));
				}
				if(strpos($line, 'description:')!== false){
					$theme_infos = array("description" => str_replace('description:', '', $line));
				}
				if(strpos($line, 'includes:')!== false){
					$theme_infos = array("includes" => str_replace('includes:', '', $line));
				}
			}

			$to_display = $to_display . 
			get_block_div(
				get_block_link(
					'themes.php?switch_to_theme=' . $themes[$i], 
					get_block_image(
						$LINKS['URL'] . '/content/themes/' . $themes[$i] . '/screenshot.png',
						'',
						'theme-screenshot',
						'',
						''
					) . 
					get_block_div(
						get_block_title(
							3,
							$theme_infos['name'],
							'',
							'theme-name',
							'',
							''
							
						) .
						get_block_link(
							$theme_infos['url'],
							'',
							'',
							'',
							'',
							'theme-url',
							'',
							''
						),
						'',
						'theme-infos',
						'',
						'',
						''
					),
					'',
					'',
					'',
					'',
					'',
					''
				),
				'',
				'theme ' . $this_theme_is,
				'',
				''
			);
		}
		return $to_display;
	}