<?php
	
	//Status
	//Version 1
	//since Atoum 1
	class at_status{
		//Fields
		//Version 1
		//since Atoum 1
		private $status = ['published', 'draft', 'private'];								//Wich status can take content
		
		//Properties
		//Version 1
		//since Atoum 1
		public function get_status(){
			return $this->status;
		}
		
		//Methods
		//Version 1
		//since Atoum 1
	}