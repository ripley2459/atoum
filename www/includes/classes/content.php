<?php
		
	class content{
		//Fields
		private $id;
		private $title;
		private $slug;
		private $author_id;
		private $date_created;
		private $date_modified;
		private $type;
		private $status;
		private $parent_id;
		private $has_children;
		private $content;
		
		private $is_recovered = false;

		//Properties


		//Methods
		public function __construct(int $content_id){
			$this->id = $content_id;

			//A id of -1 indicate this instance is new or temporary
			//So if not -1 try to recover its parameters
			if($this->id != -1){
				$this->check_filling();				//let's try to recover the term
			}
		}

		public function display_as_table_row(){
			global $folder, $page, $content_type, $LINKS;
			return
			get_block_table_row(
				['template'=>'admin'],
				get_block_table_data(
					['class'=>'spoiler_container', 'template'=>'admin'],
					$this->title . '</br>' .
					get_block_div(
						['class'=>'spoiler', 'template'=>'admin'],
						get_block_link(
							$LINKS['URL'] . '/index.php?type=' . $this->type . '&content=' . $this->slug,
							['template'=>'admin'],
							'Display'
						) . ' | ' .
						get_block_modal(
							['id'=>$this->slug, 'template'=>'admin'],
							'Quick dit',
							get_block_form(
								['action'=>$page . '.php', 'method'=>'post', 'template'=>'admin'],
								$this->date_created .
								get_block_label(
									['for'=>'content_title', 'template'=>'admin'],
									'Title'
								) .
								get_block_input(
									['type'=>'text', 'name'=>'content_title', 'value'=>$this->title, 'required'=>'required', 'template'=>'admin']
								) .
								get_block_label(
									['for'=>'content_slug', 'template'=>'admin'],
									'Slug'
								) .
								get_block_input(
									['type'=>'text', 'name'=>'content_slug', 'value'=>$this->slug, 'required'=>'required', 'template'=>'admin']
								) .
								get_block_label(
									['for'=>'relations', 'template'=>'admin'],
									'Classes'
								) .
								get_block_input(
									['type'=>'text', 'name'=>'relations', 'value'=>$this->slug, 'required'=>'required', 'template'=>'admin']
								) .
								get_terms_for_menus('class') .
								get_block_input(
									['type'=>'submit', 'name'=>'update', 'value'=>'Update', 'template'=>'admin']
								)
							)
						) . ' | ' .
						get_block_link(
							$LINKS['URL'] . '/admin/'. $folder . '/editor.php?content_type=' . $content_type . '&content_to_edit=' . $this->id,
							['template'=>'admin'],
							'Edit'
						) . ' | ' .
						get_block_link(
							'#',
							['template'=>'admin'],
							'Delete'
						)
					)
				) .
				get_block_table_data(
					['template'=>'admin'],
					get_user_display_name($this->author_id)
				) .
				get_block_table_data(
					['template'=>'admin'],
					''
				) .
				get_block_table_data(
					['template'=>'admin'],
					$this->date_created
				) .
				get_block_table_data(
					['template'=>'admin'],
					$this->date_modified
				)
			);
		}

		//Check if this content exist in the database. If yes, recover its parameters
		private function check_filling(){
			global $DDB;
			if($this->is_recovered == false){
				$sql = 'SELECT * FROM at_content WHERE content_id = :content_id';
				$request_content_recover = $DDB->prepare($sql);
				$request_content_recover->execute([':content_id'=>$this->id]);

				if($request_content_recover){
					$content = $request_content_recover->fetch();

					$this->id = $content['content_id'];
					$this->title = $content['content_title'];
					$this->slug = $content['content_slug'];
					$this->author_id = $content['content_author_id'];
					$this->date_created = $content['content_date_created'];
					$this->date_modified = $content['content_date_modified'];
					$this->type = $content['content_type'];
					$this->status = $content['content_status'];
					$this->parent_id = $content['content_parent_id'];
					$this->has_children = $content['content_has_children'];
					$this->content = $content['content_content'];

					$this->is_recovered == true;
				}

				$request_content_recover->closeCursor();
			}
		}
	}