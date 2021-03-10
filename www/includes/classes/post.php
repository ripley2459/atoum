<?php
		
	class post{
		//this->file_title		
		//Fields
		private $post_id;					//The post ID
		private $post_title;				//The post title
		private $post_slug;					//The post slug
		private $post_author_id;			//Who the fuck has writen thoses bulshit
		private $post_date_created;			//When the post has been whriten
		private $post_type = 'post';		//The post type, obviously it's 'post'
		private $post_status;				//Is this post published, privataly or whatever
		private $post_parent_id;			//The post parent ID
		private $post_has_children;			//Does this post has children (what a rabbit)
		private $post_content;				//Yep, sometime you have something to show
		
		private $is_recovered = false;		//is this post filled?

		//Properties

		//Methods
		public function __construct($post_id){
			$this->post_id = $post_id;
		}
		
		public function _display_preview(){
			//Display a preview of this post
			$this->check_filling();				//let's try to recover the post
			echo get_block_div(
				$array = array('class' => 'post post-' . $this->post_id . ' ' . $this->post_status, 'template' => 'post'),
				get_block_div(
					$array = array('class' => 'post-infos', 'template' => 'post'),
					get_block_span(
						$array = array('class' => 'post post-' . $this->post_id . ' post_author-display-name', 'template' => 'post'),
						get_user_display_name($this->post_author_id)
					) .
					get_block_span(
						$array = array('class' => 'post post-' . $this->post_id . ' post_date-created', 'template' => 'post'),
						$this->post_date_created
					)
				) .
				get_block_link(
					URL . '/index.php?type=post&content=' . $this->post_slug,
					$array = array('template' => 'admin'),
					get_block_title(
						2,
						$array = array('class' => 'post-link', 'template' => 'post'),
						$this->post_title
					)
				)
			);
		}
		
		public function _display(){
			$this->check_filling();				//let's try to recover the post
			echo get_block_div(
				$array = array('class' => 'post post-' . $this->post_id . ' ' . $this->post_status, 'template' => 'post'),
				get_block_div(
					$array = array('class' => 'post-infos', 'template' => 'post'),
					get_block_span(
						$array = array('class' => 'post post-' . $this->post_id . ' post_author-display-name', 'template' => 'post'),
						get_user_display_name($this->post_author_id)
					) .
					get_block_span(
						$array = array('class' => 'post post-' . $this->post_id . ' post_date-created', 'template' => 'post'),
						$this->post_date_created
					)
				) .
				get_block_link(
					URL . '/index.php?type=post&content=' . $this->post_slug,
					$array = array('template' => 'admin'),
					get_block_title(
						2,
						$array = array('class' => 'post-link', 'template' => 'post'),
						$this->post_title
					)
				)
			);
		}
		
		public function _add(){
			
		}
		
		public function _update(){
			
		}
		
		public function _delete(){
			global $DDB;
			$request_post_delete = $DDB->prepare('DELETE FROM at_content WHERE content_id = :content_id');
			$request_post_delete->execute(array(':content_id' => $this->post_id));
			$request_post_delete->closeCursor();
		}
		
		private function check_filling(){
			global $DDB;
			if($this->is_recovered == false){
				$msq = 'SELECT * FROM ' . 'at' . '_content WHERE content_id = :content_id';
				$request_post_recover = $DDB->prepare($msq);
				$request_post_recover->execute(array(':content_id' => $this->post_id));

				if($request_post_recover){
					$post = $request_post_recover->fetch();

					$this->post_title = $post['content_title'];
					$this->post_slug = $post['content_slug'];
					$this->post_author_id = $post['content_author_id'];
					$this->post_date_created = $post['content_date_created'];
					$this->post_status = $post['content_status'];
					$this->post_parent_id = $post['content_parent_id'];
					$this->post_has_children = $post['content_has_children'];
					$this->post_content = $post['content_content'];

					$this->is_recovered == true;
				}

				$request_post_recover->closeCursor();
			}
		}
	}