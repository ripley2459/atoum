<?php

	//File
	//Version 1
	//Since Atoum 1
	class file{
		//Fields
		//Version 1
		//Since Atoum 1
		private $file_id;
		private $file_title;
		private $file_slug;
		private $file_author_id;
		private $file_type;
		private $file_status;
		private $file_parent_id;
		private $file_has_children;
		private $file_content;

		//Properties
		//Version 1
		//Since Atoum 1

		//Methods
		//Version 1
		//Since Atoum 1
		
		//Construct
		//Version 1
		//Since Atoum 1
		public function __construct(string $file_title, int $file_author_id, string $file_type, int $file_parent_id, int $file_has_children, string $file_content){
			$this->file_title = $file_title;
			$this->file_slug = preg_replace('/[^a-zA-Z0-9-_\.]/', '-', $file_title);
			$this->file_author_id = $file_author_id;
			$this->file_type = $file_type;
			$this->file_status = 'uploaded';
			$this->file_parent_id = $file_parent_id;
			$this->file_has_children = $file_has_children;
			$this->file_content = $file_content;
		}

		//upload a file and register it on the database
		//Version 1
		//Since Atoum 1
		public function upload_file(){
			global $DDB;
			$request_upload_file = $DDB->prepare('INSERT INTO at_content (content_title, content_slug, content_author_id, content_type, content_status, content_parent_id, content_has_children, content_content) VALUES (:content_title, :content_slug, :content_author_id, :content_type, :content_status, :content_parent_id, :content_has_children, :content_content)');
			$request_upload_file->execute(array(':content_title' => $this->file_title, ':content_slug' => $this->file_slug, ':content_author_id' => $this->file_author_id, ':content_type' => $this->file_type, ':content_status' => $this->file_status, ':content_parent_id' => $this->file_parent_id, ':content_has_children' => $this->file_has_children, ':content_content' => $this->file_content));
			$request_upload_file->closeCursor();
		}

		//update row of the filed inside the database
		//Version 1
		//Since Atoum 1
		public function update_file(){
			global $DDB;
			$request_update_file = $DDB->prepare('UPDATE at_content SET content_title = :content_title, content_slug = :content_slug, content_author_id = :content_author_id, content_type = :content_type, content_status = :content_status, content_parent_id = :content_parent_id, content_has_children = :content_has_children, content_content = :content_content WHERE content_id = :content_id');
			$request_update_file->execute(array(':content_title' => $this->file_title, ':content_slug' => $content_slug, ':content_author_id' => $this->file_author_id, ':content_type' => $this->file_type, ':content_status' => $this->file_status, ':content_parent_id' => $this->file_parent_id, ':content_has_children' => $this->file_has_children, ':content_content' => $this->file_content, ':content_id' => $this->file_id));
			$request_update_file->closeCursor();
		}

		//Remove the file from the database and from the hd
		//Version 1
		//Since Atoum 1
		public function delete_file(){
			global $DDB;
			if(unlink($this->file_content)){
				//If the file has been successfully deleted then remove its database entry
				$request_delete_file = $DDB->prepare('DELETE FROM at_content WHERE content_id = :content_id');
				$request_delete_file->execute(array(':content_id' => $this->file_id));
				$request_delete_file->closeCursor();
			}
		}

		//Get informations of the file from the database
		//Version 1
		//Since Atoum 1
		public function recover_file(){
			global $DDB;
			$get_file_request = $DDB -> prepare('SELECT * FROM at_content WHERE content_status = :content_status');
			$get_file_request -> execute(array(':content_status' => 'uploaded', ':order_by' => 'content_date_created', ':order_direction' => 'DESC'));
		}
	}