<?php

	//                 AAA                tttt                                                                     
	//                A:::A            ttt:::t                                                                     
	//               A:::::A           t:::::t                                                                     
	//              A:::::::A          t:::::t                                                                     
	//             A:::::::::A   ttttttt:::::ttttttt       ooooooooooo   uuuuuu    uuuuuu     mmmmmmm    mmmmmmm   
	//            A:::::A:::::A  t:::::::::::::::::t     oo:::::::::::oo u::::u    u::::u   mm:::::::m  m:::::::mm 
	//           A:::::A A:::::A t:::::::::::::::::t    o:::::::::::::::ou::::u    u::::u  m::::::::::mm::::::::::m
	//          A:::::A   A:::::Atttttt:::::::tttttt    o:::::ooooo:::::ou::::u    u::::u  m::::::::::::::::::::::m
	//         A:::::A     A:::::A     t:::::t          o::::o     o::::ou::::u    u::::u  m:::::mmm::::::mmm:::::m
	//        A:::::AAAAAAAAA:::::A    t:::::t          o::::o     o::::ou::::u    u::::u  m::::m   m::::m   m::::m
	//       A:::::::::::::::::::::A   t:::::t          o::::o     o::::ou::::u    u::::u  m::::m   m::::m   m::::m
	//      A:::::AAAAAAAAAAAAA:::::A  t:::::t    tttttto::::o     o::::ou:::::uuuu:::::u  m::::m   m::::m   m::::m
	//     A:::::A             A:::::A t::::::tttt:::::to:::::ooooo:::::ou:::::::::::::::uum::::m   m::::m   m::::m
	//    A:::::A               A:::::Att::::::::::::::to:::::::::::::::o u:::::::::::::::um::::m   m::::m   m::::m
	//   A:::::A                 A:::::A tt:::::::::::tt oo:::::::::::oo   uu::::::::uu:::um::::m   m::::m   m::::m
	//  AAAAAAA                   AAAAAAA  ttttttttttt     ooooooooooo       uuuuuuuu  uuuummmmmm   mmmmmm   mmmmmm

	namespace Atoum;

	// if the generated file during the instalation process doesn't exist, redict to the instalation page
	// this process will be rework later
	if( ! file_exists( 'settings.php' ) ) header( 'Location: admin/installer.php' );

	// Atoum's settings
	require 'settings.php';
	require 'config.php';
	require 'imports.php';
	require 'load.php';

	// page construction
	require 'head.php';
	require 'body.php';