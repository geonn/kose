<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class testCase extends Web_Controller {

	/** Module name **/
	public $name        = 'testCase';	
	function __construct() {
		parent::__construct();	
	}
	
	/***
	* create contestant data from form
	* @param: 
	***/
	function createContestant(){ 
		$this->param['name'] = "James Loo"; 
		$this->param['email'] = "james@gmail.com"; 
		$this->param['mobile'] = "0143456789"; 
		$this->param['ic'] = "831241219421"; 
		$this->param['state'] = "kv"; 
		$this->param['agreement'] = "1"; 
		$this->param['tnc'] = "1"; 
		$result = $this->contestant_model->addContestant();	  
		
		echo generate_json($result);	 
	}
	
	/***
	* update contestant data with specific field to amend
	* @param:
	***/
	function updateInfo(){
		$result = array();
		$this->param['id'] = "2";
		$this->param['tac'] = tac_generator(); 
		$result['tac'] = $this->contestant_model->updateContestantWithField('tac');	 
		
		$this->param['area'] = "2";
		$result['area'] = $this->contestant_model->updateContestantWithField('area');
		
		echo generate_json($result);	 
	}
	
	function generateVoucher(){
		$this->param['prize_id'] = "2";	
		$this->param['area_id'] = "ns";	
		$this->param['amount'] = 3;	
		 
		$this->voucher_model->addVoucher();
	}
}