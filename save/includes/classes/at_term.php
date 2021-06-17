<?php

	//Term
	//Version 1
	//Since Atoum 1
	class at_term{
		//Fields
		//Version 1
		//since Atoum 1
		private $id;								//ID, if you known, you known
		private $name;								//Display name of this term
		private $slug;								//Slug of this term. A normalized string
		private $type = 'class';					//What kind of term is this
		private $parent_id;							//Does this term has a prent
		private $description;						//Description. Obviously i guess

		private $is_recovered = false;				//Does this term exist in the database and has been recovered in that instance

		//Properties
		//Version 1
		//since Atoum 1
		//id
		public function get_id(){
			return $this->id;
		}

		//Name
		public function set_name($name){
			$this->name = $name;
		}

		public function get_name(){
			return $this->name;
		}

		//Slug
		public function set_slug($slug){
			$this->slug = $slug;
		}

		public function get_slug(){
			return $this->slug;
		}

		//parent id
		public function set_parent_id($parent_id){
			$this->parent_id = $parent_id;
		}

		public function get_parent_id(){
			return $this->parent_id;
		}

		//Set description
		public function set_description($description){
			$this->description = $description;
		}

		public function get_description(){
			return $this->description;
		}

		//Methods
		//Construct
		//Version 1
		//since Atoum 1
		public function __construct(int $term_id){
			$this->id = $term_id;

			//A id of -1 indicate this instance is new or temporary
			//So if not -1 try to recover its parameters
			if($this->id != -1){
				$this->check_filling();				//let's try to recover the term
			}
		}

		//Display this term as a table row. Used in the admin page terms
		//Version 1
		//since Atoum 1
		public function display_as_table_row(){
			return
			get_block_table_row(
				$array = array('template'=>'admin'),
				get_block_table_data(
					$array = array('class'=>'spoiler_container', 'template'=>'admin'),
					$this->name . '</br>' .
					get_block_div(
						$array = array('class'=>'spoiler', 'template'=>'admin'),
						get_block_link(
							'#',
							$array = array('template'=>'admin'),
							'Display'
						) . ' | ' .
						get_block_link(
							'terms.php?term_to_edit=' . $this->id,
							$array = array('template'=>'admin'),
							'Edit'
						) . ' | ' .
						get_block_link(
							'classes.php?term_to_delete=' . $this->id,
							$array = array('template'=>'admin'),
							'Delete'
						)
					)
				) .
				get_block_table_data(
					$array = array('template'=>'admin'),
					$this->slug
				) .
				get_block_table_data(
					$array = array('template'=>'admin'),
					$this->description
				) .
				get_block_table_data(
					$array = array('template'=>'admin'),
					'X'
				)
			);
		}

		//Display this term as option inside a html select
		//Version 1
		//since Atoum 1
		public function display_as_option(){
			return '<option value="' . $this->id . '">' . $this->name . '</option>';
		}

		//Insert this instance of the term in the database
		//Version 1
		//since Atoum 1
		public function insert(){
			global $DDB;
			$sql = 'INSERT INTO at_terms SET term_name = :term_name, term_slug = :term_slug, term_type = :term_type, term_parent_id = :term_parent_id, term_description = :term_description';
			$request_term_insert = $DDB->prepare($sql);
			$request_term_insert->execute([':term_name'=>$this->name, ':term_slug'=>$this->slug, ':term_type'=>$this->type, ':term_parent_id'=>$this->parent_id, ':term_description'=>$this->description]);
			$request_term_insert->closeCursor();
		}

		//update the existing term in the database with this instance
		//Version 1
		//since Atoum 1
		public function edit(string $term_name, string $term_slug, string $term_description, int $term_parent_id){
			global $DDB;
			$sql = 'UPDATE at_terms SET term_name = :term_name, term_slug = :term_slug, term_description = :term_description, term_parent_id = :term_parent_id WHERE term_id = :term_id';
			$request_term_edit = $DDB->prepare($sql);
			$request_term_edit->execute([':term_name'=>$term_name, ':term_slug'=>$term_slug, ':term_description'=> $term_description, ':term_parent_id'=>$term_parent_id, ':term_id'=>$this->id]);
			$request_term_edit->closeCursor();
		}

		//Do I really need what this function do?
		//Version 1
		//since Atoum 1
		public function remove(){
			global $DDB;
			$request_term_remove = $DDB->prepare('DELETE FROM at_terms WHERE term_id = :term_id');
			$request_term_remove->execute([':term_id'=>$this->id]);
			$request_term_remove->closeCursor();
		}

		//Check if this term exist in the database. If yes, recover its parameters
		//Version 1
		//since Atoum 1
		private function check_filling(){
			global $DDB;
			if($this->is_recovered == false){
				$sql = 'SELECT * FROM at_terms WHERE term_id = :term_id';
				$request_term_recover = $DDB->prepare($sql);
				$request_term_recover->execute([':term_id'=>$this->id]);

				if($request_term_recover){
					$post = $request_term_recover->fetch();

					$this->name = $post['term_name'];
					$this->slug = $post['term_slug'];
					$this->type = $post['term_type'];
					$this->description = $post['term_description'];
					$this->parent_id = $post['term_parent_id'];

					$this->is_recovered == true;
				}

				$request_term_recover->closeCursor();
			}
		}
	}