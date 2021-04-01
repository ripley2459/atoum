<?php
	
	//Status
	//Version 1
	class at_status{
		//Fields
		private $status = ['published', 'draft', 'private'];								//Wich status can take content
		
		//Properties
		public function get_status(){
			return $this->status;
		}
		
		//Methods
	}