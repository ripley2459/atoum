<?php
		
	class file{
		//Fields
		private $content_id;
		private $content_title;
		private $content_slug;
		private $content_author_id;
		private $content_type;
		private $content_status;
		private $content_parent_id;
		private $content_has_children;
		private $content_content;

		//Properties
		//Set
/* 		public function set_name(string $name){
			$this->$name;
		} */

		//Get
/* 		public function get_name(){
			return $this->name;
		} */

		//Methods
		public function __construct(){

		}

		public function upload_file(){
			global $DDB;

			$request_upload_file = $DDB->prepare('INSERT INTO at_content (content_title, content_slug, content_author_id, content_type, content_status, content_parent_id, content_has_children, content_content) VALUES (:content_title, :content_slug, :content_author_id, :content_type, :content_status, :content_parent_id, :content_has_children, :content_content)');
			$request_upload_file->execute(array(':content_title' => $this->file_title, ':content_slug' => $this->file_slug, ':content_author_id' => $this->file_author_id, ':content_type' => $this->file_type, ':content_status' => $this->file_status, ':content_parent_id' => $this->file_parent_id, ':content_has_children' => $this->file_has_children, ':content_content' => $this->file_content));
			$request_upload_file->closeCursor();
		}

		public function update_file(){
			global $DDB;
			$request_update_file = $DDB->prepare('UPDATE at_content SET content_title = :content_title, content_slug = :content_slug, content_author_id = :content_author_id, content_type = :content_type, content_status = :content_status, content_parent_id = :content_parent_id, content_has_children = :content_has_children, content_content = :content_content WHERE content_id = :content_id');
			$request_update_file->execute(array(':content_title' => $this->file_title, ':content_slug' => $content_slug, ':content_author_id' => $this->file_author_id, ':content_type' => $this->file_type, ':content_status' => $this->file_status, ':content_parent_id' => $this->file_parent_id, ':content_has_children' => $this->file_has_children, ':content_content' => $this->file_content, ':content_id' => $this->file_id));
			$request_update_file->closeCursor();
		}

		public function delete_file(){
			global $DDB;
			if(unlink($this->file_content)){
				//If the file has been successfully deleted then remove its database entry
				$request_delete_file = $DDB->prepare('DELETE FROM at_content WHERE content_id = :content_id');
				$request_delete_file->execute(array(':content_id' => $this->file_id));
				$request_delete_file->closeCursor();
			}
		}
		
		public function recover_file(){
			global $DDB;
			$get_file_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_status = :content_status');
			$get_file_request -> execute(array(':content_status' => 'uploaded', ':order_by' => 'content_date_created', ':order_direction' => 'DESC'));

		}
	}