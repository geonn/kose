<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class slogan extends Web_Controller {

	/** Module name **/
	public $name        = 'slogan';	
	function __construct() {
		parent::__construct();	
	}
	
	public function index(){
		$data = array(); 
		echo encode_key('123');
		echo decode_key('MTIz');
		$this->_render_form('index',$data);
	}
	
	/***
	* submit slogan from contestant
	* @param: 
	***/
	public function createSlogan(){
		$result = $this->contestant_model->updateContestantWithField('slogan');	   
		echo generate_json($result);	 
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */