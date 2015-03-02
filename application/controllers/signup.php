<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class signup extends Web_Controller {

	/** Module name **/
	public $name        = 'signup';	
	function __construct() {
		parent::__construct();	
	}
	
	public function index(){
		$data = array(); 
		$this->_render_form('index',$data);
	}
	
	/***
	* create contestant data from form
	* @param: 
	***/
	function createContestant(){   
		$result = $this->contestant_model->addContestant();	   
		echo generate_json($result);	 
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */