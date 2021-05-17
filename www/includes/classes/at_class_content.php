<?php

class at_class_content {
    // FIELDS
    private $id;
    private $title;
    private $slug;
    private $type;
    private $origin;
    private $status;
    private $author_id;
    private $path;
    private $content;
    private $date_created;
    private $date_modified;

    // PROPERTIES
    // id
    public function set_id( int $id ) {
        $this->id = $id;
    }

    public function get_id() {
        return $this->id;
    }

    // title
    public function set_title( string $title ) {
        $this->title = $title;
    }

    public function get_title() {
        return $this->title;
    }

    // slug
    public function set_slug( string $slug ) {
        $this->slug = $slug;
    }

    public function get_slug() {
        return $this->slug;
    }

    // type
    public function set_type( string $type ) {
        $this->type = $type;
    }

    public function get_type() {
        return $this->type;
    }

    // origin
    public function set_origin( string $origin ) {
        $this->origin = $origin;
    }

    public function get_origin() {
        return $this->origin;
    }

    // status
    public function set_status( string $status ) {
        $this->status = $status;
    }

    public function get_status() {
        return $this->slug;
    }

    // author_id
    public function set_author_id( int $author_id ) {
        $this->slug = $slug;
    }

    public function get_author_id() {
        return $this->author_id;
    }

    // path
    public function set_path( string $path ) {
        $this->path = $path;
    }

    public function get_path() {
        return $this->path;
    }

    // content
    public function set_content( string $content ) {
        $this->content = $content;
    }

    public function get_content() {
        return $this->content;
    }

    // date created
    public function set_date_created( string $date_created ) {
        $this->date_created = $date_created;
    }

    public function get_date_created() {
        return $this->date_created;
    }

    // date modified
    public function set_date_modified( string $date_modified ) {
        $this->date_modified = $date_modified;
    }

    public function get_date_modified() {
        return $this->date_modified;
    }

    // METHODS
    // __construct
    public function __construct( int $content_id ) {
        $this->id = $content_id;
        // an id of -1 indicate this instance is new or temporary
        // so if not -1 try to recover its parameters
        if( $this->id != -1 ) $this->retrieve();
    }

    // add
    // insert this instance inside the databse
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
            content_content = :content_content,
            content_date_created = :content_date_created,
            content_date_modified = :content_date_modified
        ';

        $rqst_content_add = $DDB->prepare( $sql0 );

        $rqst_content_add->execute( [ 
            ':content_title' => $this->title,
            ':content_slug' => $this->slug,
            ':content_type' => $this->type,
            ':content_origin' => $this->origin,
            ':content_status' => $this->status,
            ':content_author_id' => $this->author_id,
            ':content_path' => $this->path,
            ':content_content' => $this->content,
            ':content_date_created' => $this->date_created,
            ':content_date_modified' => $this->date_modified
        ] );

        $rqst_content_add->closeCursor();
    }

    // edit
    // edit the existing content in the database with this instance
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
            content_content = :content_content,
            content_date_created = :content_date_created,
            content_date_modified = :content_date_modified
        ';

        $rqst_content_edit = $DDB->prepare( $sql0 );

        $rqst_content_edit->execute( [ 
            ':content_title' => $this->title,
            ':content_slug' => $this->slug,
            ':content_type' => $this->type,
            ':content_origin' => $this->origin,
            ':content_status' => $this->status,
            ':content_author_id' => $this->author_id,
            ':content_path' => $this->path,
            ':content_content' => $this->content,
            ':content_date_created' => $this->date_created,
            ':content_date_modified' => $this->date_modified
        ] );

        $rqst_content_edit->closeCursor();
    }

    public function remove() {
		global $DDB;

		$sql0 = 'DELETE FROM ' . PREFIX . 'content WHERE content_id = :content_id';

		$rqst_content_remove = $DDB->prepare( $sql0 );
		$rqst_content_remove->execute( [ ':content_id' => $this->id ] );

		$rqst_content_remove->closeCursor();
    }

    // check filling
    // check if this content exist in the database. If yes, recover its parameters
    private function retrieve() {
        global $DDB;
        if( $this->is_recovered == false ) {

            $sql0 = 'SELECT * FROM ' . PREFIX . 'content WHERE content_id = :content_id';

            $rqst_content_retrieve = $DDB -> prepare( $sql0 );
            $rqst_content_retrieve -> execute( [ ':content_id' => $this->id ] );

            if( $rqst_content_retrieve ) {
                $content = $rqst_content_retrieve -> fetch();

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

            $rqst_content_retrieve -> closeCursor();
        }
    }
}