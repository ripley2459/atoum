<?php

	function get_themes_wrapper(){
		global $LINKS, $THEME;
		$themes = scandir($LINKS['THEMES']);	
		$themes_folder_size = count($themes) - 1;
		$to_display = '';

		for($i = 2; $i <= $themes_folder_size; $i++){
			$theme_infos = '';
			if($themes[$i] == $THEME){
				$this_theme_is = 'enabled';
			}
			else{
				$this_theme_is = 'disabled';
			}

			$to_display = $to_display . 
			get_block_div(
				get_block_link(
					'themes.php?switch_to_theme=' . $themes[$i], 
					get_block_image(
						$LINKS['URL'] . '/content/themes/' . $themes[$i] . '/includes/screenshot.png',
						'',
						'theme-screenshot',
						'',
						''
					) . 
					get_block_div(
						get_block_title(
							3,
							$themes[$i],
							'',
							'theme-name',
							'',
							''
							
						) .
						get_block_link(
							'URL',
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
		
/* 
	$infos = fopen($LINKS['THEMES'].$themes[$i].'/infos.txt','r');
	while(!feof($infos)){
	$line = fgets($infos);
	if(strpos($line, 'Name:')!== false){
		echo '<h3>'.str_replace('Name: ','', $line).'</h3>';
	}
	while(!feof($infos)){
		scan_line(fgets($infos));
	}
	fclose($infos);
	if($this_theme_is == 'activated'){
		//echo '<a href="#">Deactivate<a>';
	}
*/

		return $to_display;
	}