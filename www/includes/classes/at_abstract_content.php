<?php

	namespace Atoum;

	/**
	 * Abstract class used for everything that fit inside the content table of the database.
	 * @author Cyril Neveu
	 * @since 2021/09/20
	 * @abstract
	 * @uses use this class for inheritance.
	 */
	abstract class at_abstract_content {

		///////////////////////////////////////////////////////////////////////////////////////////
		// FIELDS

		/**
		 * @var int is the post's id.
		 * @since 2021/06/09
		 */
		protected $id;

		/**
		 * @var string is the post's title.
		 * @since 2021/06/09
		 */
		protected $title = '';

		/**
		 * @var string is the post's slug.
		 * @since 2021/06/09
		 */
		protected $slug = '';

		/**
		 * @var int is the post's type: post.
		 * @since 2021/06/09
		 */
		protected $type = 'post';

		/**
		 * @var int is the post's origin: created, uploaded.
		 * @since 2021/06/09
		 */
		protected $origin = 'created';

		/**
		 * @var int is the post's status: published, private, draft or private draft.
		 * @since 2021/06/09
		 */
		protected $status = 'published';

		/**
		 * @var int is the post's author id.
		 * @since 2021/06/09
		 */
		protected $author_id = 0;

		/**
		 * @var string is the post's content's path. (For something isn't sored in the database.)
		 * @since 2021/06/09
		 */
		protected $path = '';

		/**
		 * @var string is the post's content.
		 * @since 2021/06/09
		 */
		protected $content = '';

		/**
		 * @var string is when the post has been created. Managed by the database.
		 * @since 2021/06/09
		 */
		protected $date_created = '0000-00-00 00:00:00';

		/**
		 * @var string is when the post has been modified. Managed by the database.
		 * @since 2021/06/09
		 */
		protected $date_modified = '0000-00-00 00:00:00';

		/**
		 * @var bool = true if the this instance is retrieved from the database.
		 * retrieved mean informations has been loaded inside this instance.
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
		public function get_id() {
			return $this->id;
		}

		/**
		 * @property-read int $title return title.
		 * @property-write int $title set title.
		 * @since 2021/06/09
		 */
		public function set_title( string $title ) {
			$this->title = $title;
		}
		public function get_title() {
			return $this->title;
		}

		/**
		 * @property-read int $slug return slug.
		 * @property-write int $slug set slug.
		 * @since 2021/06/09
		 */
		public function set_slug( string $slug ) {
			$this->slug = $slug;
		}
		public function get_slug() {
			return $this->slug;
		}

		/**
		 * @property-read int $type return type.
		 * @property-write int $type set type.
		 * @since 2021/06/09
		 */
		public function set_type( string $type ) {
			$this->type = $type;
		}
		public function get_type() {
			return $this->type;
		}

		/**
		 * @property-read int $origin return origin.
		 * @property-write int $origin set origin.
		 * @since 2021/06/09
		 */
		public function set_origin( string $origin ) {
			$this->origin = $origin;
		}
		public function get_origin() {
			return $this->origin;
		}

		/**
		 * @property-read string $status return status.
		 * @property-write string $status set status.
		 * @since 2021/06/09
		 */
		public function set_status( string $status ) {
			$this->status = $status;
		}
		public function get_status() {
			return $this->status;
		}

		/**
		 * @property-read int $author_id return author_id.
		 * @property-write int $author_id set author_id.
		 * @since 2021/06/09
		 */
		public function set_author_id( int $author_id ) {
			$this->author_id = $author_id;
		}
		public function get_author_id() {
			return $this->author_id;
		}

		/**
		 * @property-read string $path return path.
		 * @property-write string $path set path.
		 * @since 2021/06/09
		 */
		public function set_path( string $path ) {
			$this->path = $path;
		}
		public function get_path() {
			return $this->path;
		}

		/**
		 * @property-read string $content return content.
		 * @property-write string $content set content.
		 * @since 2021/06/09
		 */
		public function set_content( string $content ) {
			$this->content = $content;
		}
		public function get_content() {
			return $this->content;
		}

		/**
		 * @property-read string $date_created return date_created.
		 * @property-write string $date_created set date_created.
		 * @since 2021/06/09
		 */
		public function set_date_created( string $date_created ) {
			$this->date_created = $date_created;
		}
		public function get_date_created() {
			return $this->date_created;
		}

		/**
		 * @property-read string $date_modified return date_modified.
		 * @property-write string $date_modified set date_modified.
		 * @since 2021/06/09
		 */
		public function set_date_modified( string $date_modified ) {
			$this->date_modified = $date_modified;
		}
		public function get_date_modified() {
			return $this->date_modified;
		}

		///////////////////////////////////////////////////////////////////////////////////////////
		// METHODS

		/**
		 * Super.
		 */
		public function __construct( int $content_id ) {
			$this->id = $content_id;
			// An id of -1 indicate this instance is new or temporary.
			// So if not -1 try to recover its parameters.
			if ( $this->id != -1 ) $this->retrieve();
		}

		/**
		 * Save this instance inside the database.
		 * @since 2021/09/20
		 */
		public function add() {
			global $DDB;
			$sql0 = 'INSERT INTO ' . PREFIX . 'content SET
				content_title = :content_title,
				content_slug = :content_slug,
				content_type = :content_type,
				content_origin = :content_origin,
				content_status = :content_status,
				content_author_id = :content_author_id,
				content_path = :content_path,
				content_content = :content_content';
			$rqst0 = $DDB->prepare( $sql0 );
			$rqst0->execute( [ 
				':content_title' => $this->title,
				':content_slug' => $this->slug,
				':content_type' => $this->type,
				':content_origin' => $this->origin,
				':content_status' => $this->status,
				':content_author_id' => $this->author_id,
				':content_path' => $this->path,
				':content_content' => $this->content
			] );
			$rqst0->closeCursor();
		}

		/**
		 * Remove this instance from the database.
		 * @since 2021/09/20
		 */
		public function remove() {
			global $DDB;
			$sql0 = 'DELETE FROM ' . PREFIX . 'content WHERE content_id = :content_id';
			$rqst0 = $DDB->prepare( $sql0 );
			$rqst0->execute( [ ':content_id' => $this->id ] );
			$rqst0->closeCursor();
		}

		/**
		 * Update the databases informations using this instance.
		 * @since 2021/09/20
		 */
		public function edit() {
			global $DDB;
			$sql0 = 'UPDATE INTO ' . PREFIX . 'content SET
				content_title = :content_title,
				content_slug = :content_slug,
				content_type = :content_type,
				content_origin = :content_origin,
				content_status = :content_status,
				content_author_id = :content_author_id,
				content_path = :content_path,
				content_content = :content_content';
			$rqst0 = $DDB->prepare( $sql0 );
			$rqst0->execute( [ 
				':content_title' => $this->title,
				':content_slug' => $this->slug,
				':content_type' => $this->type,
				':content_origin' => $this->origin,
				':content_status' => $this->status,
				':content_author_id' => $this->author_id,
				':content_path' => $this->path,
				':content_content' => $this->content
			] );
			$rqst0->closeCursor();
		}

		/**
		 * Check if the content exist in the database.
		 * If exist, get informations and store its inside this instance.
		 * @since 2021/06/09
		 */
		protected function retrieve() {
			global $DDB;
			if( $this->is_recovered == false ) {
				$sql0 = 'SELECT * FROM ' . PREFIX . 'content WHERE content_id = :content_id';
				$rqst_content_retrieve = $DDB->prepare( $sql0 );
				$rqst_content_retrieve->execute( [ ':content_id' => $this->id ] );
				if( $rqst_content_retrieve ) {
					$content = $rqst_content_retrieve->fetch();
					$this->title = $content[ 'content_title' ];
					$this->slug = $content[ 'content_slug' ];
					$this->type = $content[ 'content_type' ];
					$this->origin = $content[ 'content_origin' ];
					$this->status = $content[ 'content_status' ];
					$this->author_id = $content[ 'content_author_id' ];
					$this->path = $content[ 'content_path' ];
					$this->content = $content[ 'content_content' ];
					$this->date_created = $content[ 'content_date_created' ];
					$this->date_modified = $content[ 'content_date_modified' ];
					$this->is_recovered == true;
				}
				$rqst_content_retrieve->closeCursor();
			}
		}

		/**
		 * Get all instances.
		 * @return array of all instances.
		 * @since 2021/09/04
		 */
		static function get_all() {
			// TO FILL
		}

		/**
		 * Display the list of all instances.
		 * Must be filled by children.
		 * @since 2021/09/24
		 */
		static function show_all_as_table() {
			// TO FILL
		}
	}