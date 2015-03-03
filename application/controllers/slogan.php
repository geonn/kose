<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class slogan extends Web_Controller {

	/** Module name **/
	public $name        = 'slogan';	
	function __construct() {
		parent::__construct();	
	}
	
	public function index($key){
		$data = array(); 
		$data['key'] = $key;
		$this->_render_form('index',$data);
	}
	
	/***
	* submit slogan from contestant
	* @param: 
	***/
	public function createSlogan($key){
		$this->param['id'] = decode_key($key);
		$result = $this->contestant_model->updateContestantWithField('slogan');	   
		echo generate_json($result);	 
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */