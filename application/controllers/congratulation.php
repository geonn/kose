<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Congratulation extends Web_Controller {

	/** Module name **/
	public $name        = 'congratulation';	
	function __construct() {
		parent::__construct();	
	}
	
	public function index($key){
		$data = array(); 
		$data['key'] = $key;    
		$data['info'] =$this->contestant_model->find_by(decode_key($key));
		if($this->voucher_model->checkAvailableByTime()) {
			$prize = $this->voucher_model->getPrizeByState($data['info']['state']);
			if($prize){
				$data['prize'] = $prize;
				$data['message'] = $this->contestant_model->winPrize($prize, $data['info']);
			}else{
				$data['message'] = 'Better luck nexttime (100% lose as no more prize available)';
			}
		}else{
			$data['message'] = 'Better luck nexttime (100% lose as this perior no more prize available)';
		}
		$this->_render_form('index',$data);
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */