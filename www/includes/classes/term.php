<?php
		
	class term{
		//Fields
		private $id;
		private $name;
		private $slug;
		private $parent_id;
		private $description;

		//Properties
		//Set
		public function set_name(string $name){
			$this->$name;
		}

		public function set_slug(string $slug){
			$this->$slug;
		}

		public function set_parent_id(int $parent_id){
			$this->$parent_id;
		}

		public function set_description(string $description){
			$this->$description;
		}

		//Get
		public function get_name(){
			return $this->name;
		}

		public function get_slug(){
			return $this->slug;
		}

		public function get_parent_id(){
			return $this->parent_id;
		}

		public function get_description(){
			return $this->description;
		}

		//Methods
		public function __construct(int $id, string $name, string $slug, int $parent_id, string $description) {
			$this->id = $id;
			$this->name = $name;
			$this->slug = $slug;
			$this->parent_id = $parent_id;
			$this->description = $description;
		}
		
		public function __destruct(){
			//https://youtu.be/ww8BinXZ5wY
		}
	}