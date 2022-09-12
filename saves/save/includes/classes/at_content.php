<?php

	//This class can handle any content that can fill a row inside the at_content table.
	//Version 1
	//since Atoum 1
	class at_content{
		//Fields
		//Version 1
		//since Atoum 1
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

		private $relations = [];
		private $is_recovered = false;

		//Properties
		//Version 1
		//since Atoum 1
		//id
		public function get_id(){
			return $this->id;
		}

		public function set_id(int $id){
			$this->id = $id;
		}

		//Title
		public function get_title(){
			return $this->title;
		}

		public function set_title(string $title){
			$this->title = $title;
		}

		//Slug
		public function get_slug(){
			return $this->slug;
		}

		public function set_slug(string $slug){
			$this->slug = $slug;
		}

		//Author id
		public function get_author_id(){
			return $this->author_id;
		}

		public function set_author_id(int $author_id){
			$this->author_id = $author_id;
		}

		//Type
		public function get_type(){
			return $this->type;
		}

		public function set_type(string $type){
			$this->type = $type;
		}

		//Status
		public function get_status(){
			return $this->status;
		}

		public function set_status(string $status){
			$this->id = $status;
		}

		//Parent id
		public function get_parent_id(){
			return $this->parent_id;
		}

		public function set_parent_id(int $parent_id){
			$this->parent_id = $parent_id;
		}

		//Has children
		public function get_has_children(){
			return $this->id;
		}

		public function set_has_children(int $has_children){
			$this->has_children = $has_children;
		}

		//Content
		public function get_content(){
			return $this->content;
		}

		public function set_content(string $content){
			$this->content = $content;
		}

		//Methods
		//construct
		//Version 1
		//since Atoum 1
		public function __construct(int $content_id){
			$this->id = $content_id;

			//A id of -1 indicate this instance is new or temporary
			//So if not -1 try to recover its parameters
			if($this->id != -1){
				$this->check_filling();				//let's try to recover the term
			}
		}

		//Display the content as a table row (for admin)
		//Version 1
		//since Atoum 1
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
							$LINKS['URL'] . '/admin/'. $folder . '/editor.php?action=update&type=' . $content_type . '&content_to_edit=' . $this->id,
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
					$this->get_relations_name()
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

		//Recover from the database relations of this content
		//Version 1
		//since Atoum 1
		public function get_relations_name(){
			global $DDB;
			
			$to_display = '';

			$sql1 = 'SELECT relation_term_id FROM at_relations WHERE relation_content_id = :relation_content_id';
			$sql2 = 'SELECT * FROM at_terms WHERE term_id = :term_id';

			$relations = $DDB->prepare($sql1);
			$terms = $DDB->prepare($sql2);

			$relations->execute([':relation_content_id'=>$this->id]);

			while($terms_id = $relations->fetch()){
				$terms->execute([':term_id'=>$terms_id['relation_term_id']]);
				$term = $terms->fetch();
				array_push($this->relations, $term['term_name']);
				$to_display .= $term['term_name'];
			}

			$relations->closeCursor();
			$terms->closeCursor();
			
			return $to_display;
		}

		//Add this content instance to the database
		//Version 1
		//since Atoum 1
		public function insert(){
			global $DDB;
			$sql = 'INSERT INTO at_content SET content_title = :content_title, content_slug = :content_slug, content_author_id = :content_author_id, content_type = :content_type, content_status = :content_status, content_parent_id = :content_parent_id, content_has_children = :content_has_children, content_content = :content_content';
			$request_content_insert = $DDB->prepare($sql);
			$request_content_insert->execute([':content_title'=>$this->title, ':content_slug'=>$this->slug, ':content_author_id'=>$this->author_id, ':content_type'=>$this->type, ':content_status'=>$this->status, ':content_parent_id'=>$this->parent_id, ':content_has_children'=>$this->has_children, ':content_content'=>$this->content]);
			$request_content_insert->closeCursor();
		}

		//Update the content from the database
		//Version 1
		//since Atoum 1
		public function edit(){
			global $DDB;
			$sql = 'UPDATE at_content SET content_title = :content_title, content_slug = :content_slug, content_author_id = :content_author_id, content_type = :content_type, content_status = :content_status, content_parent_id = :content_parent_id, content_has_children = :content_has_children, content_content = :content_content WHERE content_id = :content_id';
			$request_content_edit = $DDB->prepare($sql);
			$request_content_edit->execute([':content_title'=>$this->title, ':content_slug'=>$this->slug, ':content_author_id'=>$this->author_id, ':content_type'=>$this->type, ':content_status'=>$this->status, ':content_parent_id'=>$this->parent_id, ':content_has_children'=>$this->has_children, ':content_content'=>$this->content, ':content_id'=>$this->id]);
			$request_content_edit->closeCursor();
		}

		//Remove the content from the database
		//Version 1
		//since Atoum 1
		public function remove(){
			
		}

		//Check if this content exist in the database. If yes, recover its parameters
		//Version 1
		//since Atoum 1
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