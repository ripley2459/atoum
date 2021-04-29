<?php
	
	// menu.php
	// 2021/04/28

	// create links for a given array of string
	function create_link( string $folder, array $links ) {
		global $page;

		$is_open = false;
		if( in_array( str_replace( '.php', '', $page ), $links ) ){
			$is_open = true;
		}

		$return = '<button class="menu-element has-children';

		if( $is_open ){
			$return .= ' opened';
		}
		
		$return .= '">' . ucfirst( $folder ) . '</button>';
		
		$return .= '<div class="sub-menu';

		if( $is_open ){
			$return .= ' opened';
		}

		$return .= '">';

		foreach ($links as $link) {
			$return .= '<a href="admin.php?p=' . $link . '.php" class="">' . ucfirst( $link ) . '</a>';
		}

		$return .= '</div>';

		return $return;
	}

?>
	<!-- START ADMIN MENU -->
	<nav class="side-menu">
		<button class="menu-element has-children opened header">Atoum</button>
		<div class="sub-menu opened header">

			<?php 

				echo create_link( 'content', ['pages', 'posts', 'menus', 'uploads', 'terms'] );
				echo create_link( 'apearance', ['themes'] );
				echo create_link( 'users', ['users', 'account'] );
				echo create_link( 'settings', ['overview'] );

			?>

		</div>
	</nav>
	<!-- END ADMIN MENU -->