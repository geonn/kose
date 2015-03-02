<?php
class Voucher_Model extends APP_Model{
	public $_result = array();
	
	function __construct() {
		$this->_table      = "voucher";
		$this->primary_key = 'id';	
		$this->_result['status']     = '';
		$this->_result['error_code'] = '';
		$this->_result['data']       = array();	
	}
	
	public function checkAvailableByTime(){
		$current_hour = date("H");
		$current_window = 0;
		foreach($this->config->item('time_windows') as $key => $val){
			if($val > $current_hour){
				$current_window = $key;
				break;
			}
		}
		$won = $this->getTotalContentantForToday();
		$available = $current_window - $won;
		if($available > 0){
			echo $available."work wor fuck!";
			return true;
		}else{
			echo "not working! fuck!";
			return false;
		}
	}
	
	public function getPrizeByState($state){
		$filter = array(
			"area_id" => $state,
			"winner_date" => "0000-00-00 00:00:00",
		);
		$res = $this->get_data($filter);
		$list = array();
		foreach($res as $k => $val){
			$list[$k]['id'] = $val['id'];
			$list[$k]['prize_id'] = $val['prize_id'];
			$list[$k]['prize_reference'] = $val['prize_reference']; 
		}
		 
		$this->_result['status']     = 'success'; 
		$this->_result['data']       = $list;	
		
		$randomPrizeNo = mt_rand(0, count($list)-1);
		print_pre($list[$randomPrizeNo]);
		//return $list;
	}
	
	private function getTotalContentantForToday(){
		$search = "DATE(winner_date) = DATE(now())";
		//$res = $this->get_data($search);
		$count = $this->total_count($search);
		
		return $count;
	}
	
	public function getList(){
		$filter = array(
		
		);
		$res = $this->get_data($filter);
		$list = array();
		foreach($res as $k => $val){
			$list[$k]['label'] = $val['name'];
			$list[$k]['value'] = $val['id']; 
		}
		 
		$this->_result['status']     = 'success'; 
		$this->_result['data']       = $list;		
		
		return $this->_result;
	}
	
	 
	public function addContestant(){
		 
		$check     = $this->validateParams(); 
		if(empty($check)) {
			$data = array(
				'name'		=> $this->param['name'],
				'ic'			=> $this->param['ic'],
				'mobile'	=> $this->param['mobile'], 
				'email'		=> $this->param['email'],
				'state'		=> $this->param['state'],
				'slogan'	=> !empty($this->param['slogan']) ? $this->param['slogan'] : "", 
				'created'			  => localDate(),
				'updated'			  => localDate(),
			);
			$id = $this->insert($data);
			
			$this->_result['status']     = 'success'; 
			$this->_result['data']       = $id;
		}else{
			$this->_result['status']     = 'error';
			$this->_result['error_code'] = $check;
			foreach($check as $k => $val){
				$this->_result['data'][$k] = $this->code[$val];
			}
		}
		
		return $this->_result;
	}
	
	public function editContestant(){
		$check     = $this->validateParams(); 
		
		if(empty($check)) {
			$data = array(
				'name' 					 => $this->param['name'],
				'serial' 					=> $this->param['serial'],
				'ic' 				    	  => $this->param['ic'],
				'contact_home'   => $this->param['contact_home'],
				'contact_mobile' => $this->param['contact_mobile'],
				'contact_office' 	=> $this->param['contact_office'],
				'age' 						=> $this->param['age'],
				'email' 				  => $this->param['email'],
				'mail_address' 	   => $this->param['mail_address'],
				'home_address'	=> $this->param['home_address'],
				'updated'	=> localDate(),
			);
			$id = $this->update($this->param['id'], $data);
			$this->logger_model->addLogger('edit',$this->_table, $this->param['name']);
			$this->_result['status']     = 'success'; 
			$this->_result['data']       = $id;
		}else{
			$this->_result['status']     = 'error';
			$this->_result['error_code'] = $check;
			foreach($check as $k => $val){
				$this->_result['data'][$k] = $this->code[$val];
			}
		}
	 
		return $this->_result;
	}
	 
	
	/*********************************************
	******************* ADMIN ********************
	*********************************************/
	public function admin_getList($sortby,$page=""){ 
		// Search Param
		$search = '(contestant_id != "") ';						
		if ($this->input->get('q')) {				
			$srhs = explode(' ',$this->input->get('q'));
			foreach($srhs as $srh){
				$search .= (!empty($search) ? " and ": "");		
				$search .= "(prize_reference like'%".$srh."%')  ";			
			}
		}
		
//		if(!empty($this->param['state'])) {
//			$search .= (!empty($search) ? " and ": "");					
//			$search .= "state = '".$this->param['state']."' ";
//		}
			 
		$return   = convert_sort($this->sorted,$sortby,$this->primary_key);
		$new_sort = change_sort($return['sort']);	
	 	$offset   = pageToOffset($this->config->item('per_page'),$page);
	  
		// Load Data
		$data['results'] = $this->get_data($search,$this->config->item('per_page'),$offset,$return['order'],$return['sorts']); 
		foreach($data['results'] as $k => $val){
			$info = $this->contestant_model->find_by($val['contestant_id']);
			$data['results'][$k]['name']   = $info['name'];
			$data['results'][$k]['email']  = $info['email'];
			$data['results'][$k]['mobile'] = $info['mobile'];
			$data['results'][$k]['state']  = $info['state'];
			$data['results'][$k]['ic']  	 = $info['ic'];
			$data['results'][$k]['prize']  = match($val['prize_id'],$this->config->item('prizes'));
		} 
 
		$data['count']   = $this->total_count($search);
		$data['new_sort'] = $new_sort;
		
		// Pagination		
		$config['base_url'] = $this->config->item('admin_url').'/'.$this->name.'/index/';	
		$config['total_rows'] = $data['count'];
		$this->pagination->initialize($config);		
		
		return $data;
	}
	
	/** To validate if param is correct format  **/
	private function validateParams(){
		$name	  = $this->param['name']; 
		$ic		  = $this->param['ic']; 
		$mobile	= $this->param['mobile']; 
		$email	= $this->param['email']; 
		$statusCode = array();
		if(!$name){
			$statusCode[] = 115;
		}
		if(!$ic){
			$statusCode[] = 116;
		}
		if(!$email){
			$statusCode []= 101;
		}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		    $statusCode[] = 105;
		}
		return $statusCode;
	}
	
	private function validateForm($t_id){
		if(empty($t_id)){
			return 116;
		}
		
		return $this->checkFormAuth($t_id);
		 
	}
	
}
?>
