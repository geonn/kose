<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class luckydraw extends Web_Controller {

	/** Module name **/
	public $name        = 'luckydraw';	
	function __construct() {
		parent::__construct();	
	}
	
	public function index(){
		$data = array(); 
		$this->_render_form('index',$data);
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */