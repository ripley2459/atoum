<nav class="side-menu left">
	<?php
		
		$linksA = scandir('content/');	
		$linksASize = count($linksA) - 1;

		for($i = 2; $i <= $linksASize; $i++){
			if(is_dir('content/' . $linksA[$i])){
				echo '<button id="' . $linksA[$i] . 'Button" class="menu-element has-children';
				if($folder == $linksA[$i]){
					echo ' opened';
				}
				echo '" onclick="toggleVisibility(\'' . $linksA[$i] . 'Folder\', \'' . $linksA[$i] . 'Button\')">' . ucfirst($linksA[$i]) . '<i class="icon"></i></button>';
				echo '<div id="' . $linksA[$i] . 'Folder' . '" class="sub-menu';
				if($folder == $linksA[$i]){
					echo ' opened';
				}
				echo '">';

				$linksB = scandir('content/'.$linksA[$i].'/');
				$linksBSize = count($linksB) - 1;

				for($j = 2; $j <= $linksBSize; $j++){
					if($linksB[$j] != 'functions.php' and !strpos($linksB[$j], '.js') and !strpos($linksB[$j], '.css')){
						echo '<a href="/admin/' . $linksA[$i] . '/' . $linksB[$j] . '" class="menu-element link';
						if($page . '.php' == $linksB[$j]){
							echo ' active';
						}
						echo '">' . ucfirst(str_replace('.php', '', $linksB[$j])) . '</a>';
					}
				}
				echo '</div>';
			}
			else{
				echo '<a href="/admin/content/' . $linksA[$i] . '" class="menu-element link';
				if ($page == $linksA[$i]){
					echo ' active';
				}
				echo '">' . ucfirst(str_replace('.php', '', $linksA[$i])) . '</a>';
			}
		}
	?>
</nav>