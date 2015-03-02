<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class congratulation extends Web_Controller {

	/** Module name **/
	public $name        = 'congratulation';	
	function __construct() {
		parent::__construct();	
	}
	
	public function index($key){
		$data = array(); 
		$data['key'] = $key;    
		$data['info'] =$this->contestant_model->find_by(decode_key($key));
		if($this->voucher_model->checkAvailableByTime())
		{
			$this->voucher_model->getPrizeByState($data['info']['state']);
		}
		$this->_render_form('index',$data);
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */