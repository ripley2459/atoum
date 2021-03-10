<?php
		
	class relations{
		//Fields
		private $relation_content_id;
		private $relations = [];

		//Properties
		public function get_relations(){
			global $DDB;

			$relations = $DDB->prepare('SELECT relation_term_id FROM at_relations WHERE relation_content_id = :relation_content_id');
			$terms = $DDB->prepare('SELECT * FROM at_terms WHERE term_id = :term_id');

			$relations->execute(array(':relation_content_id' => $this->relation_content_id));

			while($terms_id = $relations->fetch()){
				$terms->execute(array(':term_id' => $terms_id['relation_term_id']));

				$term = $terms->fetch();

				array_push($this->relations,$term['term_slug']);
			}

			$relations->closeCursor();
			$terms->closeCursor();

			return $this->relations;
		}

		//Methods
		public function __construct(int $relation_content_id){
			$this->relation_content_id = $relation_content_id;
		}

		public function __destruct(){
			//https://youtu.be/ww8BinXZ5wY
		}

		public function add_relation(int $term_id){
			global $DDB;

			$add_relation = $DDB->prepare('INSERT INTO at_relations (relation_content_id, relation_term_id) VALUES (:relation_content_id, :term_id)');
			$add_relation->execute(array(':relation_content_id' => $this->relation_content_id,':term_id' => $term_id));
		}
	}