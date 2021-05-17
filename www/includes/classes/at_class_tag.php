<?php

	// at_class_tag.php
	// 15:33 2021-05-06
	
	class at_class_tag {
		// FIELDS
		private $id;
		private $name;
		private $slug;
		private $type = 'tag';
		private $parent_id;
		private $description;
		private $group_id;

		private $is_recovered = false;
		
		// PROPERTIES
		// id
		// 00:56 2021-05-06
		public function get_id(){
			return $this->id;
		}

		// name
		// 00:56 2021-05-06
		public function set_name( string $name ){
			$this->name = $name;
		}

		public function get_name(){
			return $this->name;
		}

		// slug
		// 00:56 2021-05-06
		public function set_slug( string $slug ){
			$this->slug = $slug;
		}

		public function get_slug(){
			return $this->slug;
		}

		// type
		// 14:55 2021-05-06
		public function set_type( string $type ){
			$this->type = $type;
		}

		public function get_type(){
			return $type->type;
		}

		// parent id
		// 00:56 2021-05-06
		public function set_parent_id( int $parent_id ){
			$this->parent_id = $parent_id;
		}

		public function get_parent_id(){
			return $this->parent_id;
		}

		// description
		// 00:56 2021-05-06
		public function set_description( string $description ){
			$this->description = $description;
		}

		public function get_description(){
			return $this->description;
		}

		// METHODS
		// construct
		// 00:51 2021-05-06
		public function __construct( int $tag_id ) {
			$this->id = $tag_id;
			// an id of -1 indicate this instance is new or temporary
			// so if not -1 try to recover its parameters
			if( $this->id != -1 ) $this->retrieve();
		}

		// display as table row
		// 15:33 2021-05-06
		// display variables of this instance as a table row
		// primary used inside the admin panel
		public function display_as_table_row() {
			return
			'<tr>
				<td class="spoiler">' . $this->name . '
					<div class="spoiler_content">
						<a href="#">Display</a>
						<a href="admin.php?p=tags.php&tag_to_edit=' . $this->id . '">Edit</a>
						<a href="admin.php?p=tags.php&tag_to_delete=' . $this->id . '">Remove</a>
					</div>
				</td>
				<td>' . $this->slug . '</td>
				<td>' . $this->description . '</td>
				<td>X</td>
			</tr>';
		}

		// insert
		// 13:35 2021-05-06
		// insert this instance inside the databse
		public function insert() {
			global $DDB;
			$sql0 = 'INSERT INTO ' . PREFIX . 'tags SET tag_name = :tag_name, tag_slug = :tag_slug, tag_type = :tag_type, tag_parent_id = :tag_parent_id, tag_description = :tag_description';

			$rqst_tag_insert = $DDB->prepare( $sql0 );

			$rqst_tag_insert->execute( [
				':tag_name' => $this->name,
				':tag_slug' => $this->slug,
				':tag_type' => $this->type,
				':tag_parent_id' => $this->parent_id,
				':tag_description' => $this->description
			]);

			$rqst_tag_insert->closeCursor();
		}

		// edit
		// 01:05 2021-05-06
		// edit the existing tag in the database with this instance
		public function edit() {
			// TODO
			throw new InvalidArgumentException( 'NOT YET IMPLEMENTED!' );
		}

		// remove
		// 15:33 2021-05-06
		// do i really need what this function do?
		public function remove() {
			global $DDB;

			$sql0 = 'DELETE FROM ' . PREFIX . 'tags WHERE tag_id = :tag_id';

			$rqst_tag_remove = $DDB->prepare( $sql0 );
			$rqst_tag_remove->execute( [ ':tag_id' => $this->id ] );
			$rqst_tag_remove->closeCursor();
		}

		// check filling
		// 01:01 2021-05-06
		// check if this tag exist in the database. If yes, recover its parameters
		private function retrieve() {
			global $DDB;
			if( $this->is_recovered == false ) {

				$sql0 = 'SELECT * FROM ' . PREFIX . 'tags WHERE tag_id = :tag_id';

				$rqst_tag_retrieve = $DDB->prepare( $sql0 );
				$rqst_tag_retrieve->execute( [ ':tag_id' => $this->id ] );

				if( $rqst_tag_retrieve ) {
					$post = $rqst_tag_retrieve->fetch();

					$this->name = $post[ 'tag_name' ];
					$this->slug = $post[ 'tag_slug' ];
					$this->type = $post[ 'tag_type' ];
					$this->description = $post[ 'tag_description' ];
					$this->parent_id = $post[ 'tag_parent_id' ];

					$this->is_recovered == true;
				}

				$rqst_tag_retrieve->closeCursor();
			}
		}
	}