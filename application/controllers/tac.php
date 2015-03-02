<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tac extends Web_Controller {

	/** Module name **/
	public $name        = 'tac';	
	function __construct() {
		parent::__construct();	
	}
	
	public function index($key){
		$data['key'] = $key;    
		$data['info'] =$this->contestant_model->find_by(decode_key($key));
 
		$this->_render_form('index',$data);
	}
	
	public function requestTac($key){ 
		
		$this->param['id'] = decode_key($key);
		$this->param['tac'] = tac_generator(); 
		$result = $this->contestant_model->updateContestantWithField('tac');	  
		echo generate_json($result);	 
	}
	
	public function submitTac($key){ 
 
		$this->param['id'] = decode_key($key); 
		$result = $this->contestant_model->validateTac();	  
		echo generate_json($result);	 
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */