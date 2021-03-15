<?php
		
	class post{	
		//Fields
		private $id;						//The post ID
		private $title;						//The post title
		private $slug;						//The post slug
		private $author_id;					//Who the fuck has writen thoses bulshit
		private $date_created;				//When the post has been whriten
		private $type = 'post';				//The post type, obviously it's 'post'
		private $status;					//Is this post published, privataly or whatever
		private $parent_id;					//The post parent ID
		private $has_children;				//Does this post has children (what a rabbit)
		private $content;					//Yep, sometime you have something to show

		private $is_recovered = false;		//Does this post exist in the database and has been recovered? (stored in this instance)

		//Properties

		//Methods
		//Construct
		public function __construct(int $post_id){
			$this->id = $post_id;

			//A id of -1 indicate this instance is new or temporary
			//So if not -1 try to recover its parameters
			if($this->id != -1){
				$this->check_filling();		//let's try to recover the post
			}
		}

		public function display_preview(){
			//Display a preview of this post
			echo get_block_div(
				['class'=>'post post-' . $this->id . ' ' . $this->status, 'template'=>'post'],
				get_block_div(
					['class'=>'post-infos', 'template'=>'post'],
					get_block_span(
						$array = ['class'=>'post post-' . $this->id . ' author-display-name', 'template'=>'post'],
						get_user_display_name($this->author_id)
					) .
					get_block_span(
						['class'=>'post post-' . $this->id . ' date-created', 'template'=>'post'],
						$this->date_created
					)
				) .
				get_block_link(
					URL . '/index.php?type=post&content=' . $this->slug,
					$array = ['template'=>'admin'],
					get_block_title(
						2,
						['class'=>'post-link', 'template'=>'post'],
						$this->title
					)
				)
			);
		}

		public function display(){
			//Display the ful post
			echo get_block_div(
				['class'=>'post post-' . $this->id . ' ' . $this->status, 'template'=>'post'],
				get_block_div(
					['class'=>'post-infos', 'template'=>'post'],
					get_block_span(
						['class'=>'post post-' . $this->id . ' author-display-name', 'template'=>'post'],
						get_user_display_name($this->author_id)
					) .
					get_block_span(
						['class'=>'post post-' . $this->id . ' date-created', 'template'=>'post'],
						$this->date_created
					)
				) .
				get_block_link(
					URL . '/index.php?type=post&content=' . $this->slug,
					['template'=>'admin'],
					get_block_title(
						2,
						['class'=>'post-link', 'template'=>'post'],
						$this->title
					)
				)
			);
		}

		private function check_filling(){
			global $DDB;
			if($this->is_recovered == false){
				$sql = 'SELECT * FROM at_content WHERE content_id = :content_id';
				$request_recover = $DDB->prepare($sql);
				$request_recover->execute([':content_id'=>$this->id]);

				if($request_recover){
					$post = $request_recover->fetch();

					$this->title = $post['content_title'];
					$this->slug = $post['content_slug'];
					$this->author_id = $post['content_author_id'];
					$this->date_created = $post['content_date_created'];
					$this->status = $post['content_status'];
					$this->parent_id = $post['content_parent_id'];
					$this->has_children = $post['content_has_children'];
					$this->content = $post['content_content'];

					$this->is_recovered == true;
				}

				$request_recover->closeCursor();
			}
		}
	}