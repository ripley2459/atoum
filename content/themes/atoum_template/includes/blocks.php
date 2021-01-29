<?php

/*

	Thoses functions are included everywere.
	You can found usefull documentation in the Atoum's wiki on the Github page.
	Basically you can customise every html elements.

	Version 1

*/

	//Title
	function get_block_title($level, $content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<h' . $level . $id . $additional_classes . '>' . $content . '</h' . $level . '>';
				break;
		}
	}

	//Paragraph
	function get_block_paragraph($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<p' . $id . $additional_classes . '>' . $content . '</p>';
				break;
		}
	}

	//Horizontal rule
	function get_block_horizontal_rule($id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<hr' . $id . $additional_classes . '>';
				break;
		}
	}
	
	//Line break
	function get_block_line_break($id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<hr' . $id . $additional_classes . '>';
				break;
		}
	}

	//Preformatted text
	function get_block_preformatted_text($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<pre' . $id . $additional_classes . '>' . $content . '</pre>';
				break;
		}
	}

	//Div
	function get_block_div($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<div' . $id . $additional_classes . '>' . $content . '</div>';
				break;
		}
	}
	
	//Section
	function get_block_section($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<section' . $id . $additional_classes . '>' . $content . '</section>';
				break;
		}
	}

	//Link
	function get_block_link($directory, $content, $target, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($directory == ''){
					$directory = '#';
				}
				if($target != ''){
					$target = ' target="' . $target . '"';
				}
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<a href="' . $directory . '"' . $target . $id . $additional_classes . '>' . $content . '</a>';
				break;
		}
	}
	
	//Image
	function get_block_image($source, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($source == ''){
					$source = '#';
				}
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<img src="' . $source . '"' . $id . $additional_classes . '/>';
				break;
		}
	}
	
	function get_block_table($content, $id, $additional_classes, $template){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<table' . $id . $additional_classes . '>' . $content . '</table>';
				break;
		}
	}

	function get_block_table_row($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<tr' . $id . $additional_classes . '>' . $content . '</tr>';
				break;
		}
	}

	function get_block_table_heading($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<th' . $id . $additional_classes . '>' . $content . '</th>';
				break;
		}
	}
	
	function get_block_table_data($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<td' . $id . $additional_classes . '>' . $content . '</td>';
				break;
		}
	}
	
	function get_block_button($content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return '<button' . $id . $additional_classes . '>' . $content . '</button>';
				break;		
		}
	}
	
	function get_block_accordion($title, $content, $id, $additional_classes, $template, $custom){
		switch($template){
			default:
				if($id != ''){
					$id = ' id= "' . $id . '"';
				}
				if($additional_classes != ''){
					$additional_classes = ' class= "' . $additional_classes . '"';
				}
				return
				get_block_div(
					get_block_div(
						$title,
						'',
						'accordion_trigger',
						'',
						''
					) .
					get_block_div(
						$content,
						'',
						'accordion_panel',
						'',
						''
					),
					$id,
					$additional_classes,
					'',
					''
				);
				break;			
		}
	}