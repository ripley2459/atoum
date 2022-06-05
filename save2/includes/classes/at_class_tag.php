<?php

	namespace Atoum;

	class at_class_tag {

		///////////////////////////////////////////////////////////////////////////////////////////
		// FIELDS

		/**
		 * @var int is the tag's id.
		 * @since 2021/06/09
		 */
		private $id;

		/**
		 * @var string is the tag's name.
		 * @since 2021/06/09
		 */
		private $name = '';

		/**
		 * @var string is the tag's slug.
		 * @since 2021/06/09
		 */
		private $slug = '';

		/**
		 * @var string is the tag's type.
		 * @since 2021/06/09
		 */
		private $type = 'tag';

		/**
		 * @var int is the tag's parent id.
		 * @since 2021/06/09
		 */
		private $parent_id = 0;

		/**
		 * @var int is the tag's group id.
		 * @since 2021/06/09
		 */
		private $group_id = 0;

		/**
		 * @var string is the tag's description.
		 * @since 2021/06/09
		 */
		private $description = '';

		/**
		 * @var bool at true if the this instance is retrieved from the database.
		 * @since 2021/06/09
		 */
		private $is_recovered = false;
		
		///////////////////////////////////////////////////////////////////////////////////////////
		// PROPERTIES
		
		/**
		 * This variable can't be set outside the class or without the __constructor.
		 * @property-read int $id return id.
		 * @since 2021/06/09
		 */
		public function get_id(){
			return $this->id;
		}

		/**
		 * @property-read string $name return name.
		 * @property-write string $name set name. 
		 * @since 2021/06/09
		 */
		public function get_name(){
			return $this->name;
		}
		public function set_name( string $name ){
			$this->name = $name;
		}

		/**
		 * @property-read string $slug return slug.
		 * @property-write string $slug set slug. 
		 * @since 2021/06/09
		 */
		public function get_slug(){
			return $this->slug;
		}
		public function set_slug( string $slug ){
			$this->slug = $slug;
		}

		/**
		 * @property-read string $type return type.
		 * @property-write string $type set type. 
		 * @since 2021/06/09
		 */
		public function get_type(){
			return $type->type;
		}
		public function set_type( string $type ){
			$this->type = $type;
		}

		/**
		 * @property-read int $parent_id return parent_id.
		 * @property-write int $parent_id set parent_if. 
		 * @since 2021/06/09
		 */
		public function get_parent_id(){
			return $this->parent_id;
		}
		public function set_parent_id( int $parent_id ){
			$this->parent_id = $parent_id;
		}

		/**
		 * @property-read int $group_id return group_id.
		 * @property-write int $group_id set group_id. 
		 * @since 2021/06/09
		 */
		public function get_group_id(){
			return $this->group_id;
		}
		public function set_group_id( int $group_id ){
			$this->group_id = $group_id;
		}

		/**
		 * @property-read string $description return description.
		 * @property-write string $description set description. 
		 * @since 2021/06/09
		 */
		public function get_description(){
			return $this->description;
		}
		public function set_description( string $description ){
			$this->description = $description;
		}

		///////////////////////////////////////////////////////////////////////////////////////////
		// METHODS

		/**
		 * __construct
		 * @since 2021/06/09
		 */
		public function __construct( int $tag_id ) {
			$this->id = $tag_id;
			// an id of -1 indicate this instance is new or temporary
			// so if not -1 try to recover its parameters
			if( $this->id != -1 ) $this->retrieve();
		}

		/**
		 * Display as table row
		 * Display variables of this instance as a table row.
		 * Primary used inside the admin panel.
		 * @since 2021/06/09
		 */
		public function display_as_table_row() {
			return
			'<tr id="' . $this->slug . '">
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
		// insert this instance inside the databse
		public function insert() {
			global $DDB;
			$sql0 = 'INSERT INTO ' . PREFIX . 'tags SET
				tag_name = :tag_name,
				tag_slug = :tag_slug,
				tag_type = :tag_type,
				tag_parent_id = :tag_parent_id,
				tag_group_id = :tag_group_id,
				tag_description = :tag_description
			';

			$rqst_tag_insert = $DDB->prepare( $sql0 );

			$rqst_tag_insert->execute( [
				':tag_name' => $this->name,
				':tag_slug' => $this->slug,
				':tag_type' => $this->type,
				':tag_parent_id' => $this->parent_id,
				':tag_group_id' => $this->group_id,
				':tag_description' => $this->description
			] );

			$rqst_tag_insert->closeCursor();
		}

		/**
		 * Edit
		 * Edit this instance and override the existing one in the database.
		 * @since 2021/06/09
		 */
		public function edit() {
			global $DDB;

			$sql0 = 'UPDATE ' . PREFIX . 'tags SET 
				tag_name = :tag_name,
				tag_slug = :tag_slug,
				tag_type = :tag_type,
				tag_parent_id = :tag_parent_id,
				tag_group_id = :tag_group_id,
				tag_description = :tag_description
			WHERE tag_id = :tag_id';

			$rqst_tag_edit = $DDB->prepare( $sql0 );

			$rqst_tag_edit->execute( [ 
				':tag_name' => $this->name,
				':tag_slug' => $this->slug,
				':tag_type' => $this->type,
				':tag_parent_id' => $this->parent_id,
				':tag_group_id' => $this->group_id,
				':tag_description' => $this->description,
				':tag_id' => $this->id
			] );

			$rqst_tag_edit->closeCursor();
		}

		/**
		 * Remove
		 * Remove this instance from the database.
		 * @since 2021/11/22
		 */
		public function remove() {
			global $DDB;

			$sql0 = 'DELETE FROM ' . PREFIX . 'tags WHERE tag_id = :tag_id';

			$rqst_tag_remove = $DDB->prepare( $sql0 );
			$rqst_tag_remove->execute( [ ':tag_id' => $this->id ] );
			$rqst_tag_remove->closeCursor();
		}

		/**
		 * Retrieve
		 * Check if the tag exist in the database.
		 * If exist, retrieve informations and store its inside this instance.
		 * @since 2021/06/09
		 */
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
					$this->parent_id = $post[ 'tag_parent_id' ];
					$this->group_id = $post[ 'tag_group_id' ];
					$this->description = $post[ 'tag_description' ];

					$this->is_recovered == true;
				}
				else {
					throw new Exception( 'Can\'t retrieve an existing tag.' );
				}

				$rqst_tag_retrieve->closeCursor();
			}
		}
	}