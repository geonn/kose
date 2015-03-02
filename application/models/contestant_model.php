<?php
class Contestant_Model extends APP_Model{
	public $_result = array();
	
	function __construct() {
		$this->_table      = "contestant";
		$this->primary_key = 'id';	
		$this->_result['status']     = '';
		$this->_result['error_code'] = '';
		$this->_result['data']       = array();	
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
	
	private function checkContestantEligible(){
		$data = array(
			'mobile'		=> $this->param['mobile']
		);
		
		return $this->total_count($data); 
	}
	
	public function addContestant(){ 
		$check     = $this->validateParams(); 
		if(empty($check)) {
			$checkCounter = $this->checkContestantEligible();
			
			/*** Exceeded Participant Times***/
			if($checkCounter > $this->config->item('participantLimit')){
				$this->_result['status']     = 'error'; 
				$this->_result['error_code'] = 120;
				$this->_result['data']  	   = $this->code[120];
				return $this->_result;
			}
			
			$data = array(
				'name'		=> $this->param['name'],
				'ic'			=> $this->param['ic'],
				'mobile'	=> $this->param['mobile'], 
				'email'		=> $this->param['email'],
				'state'		=> $this->param['state'],
				'slogan'	=> !empty($this->param['slogan']) ? $this->param['slogan'] : "", 
				'created'	=> localDate(),
				'updated'	=> localDate(),
			);
			$id = $this->insert($data);
			
			$this->_result['status']     = 'success'; 
			$this->_result['data']       = encode_key($id);
		}else{
			$this->_result['status']     = 'error';
			$this->_result['error_code'] = $check;
			foreach($check as $k => $val){
				$this->_result['data'][$k] = $this->code[$val];
			}
		}
		
		return $this->_result;
	}
	
	public function validateTac(){
		if(empty($this->param['tac'])){
				$this->_result['status']     = 'error'; 
				$this->_result['error_code'][] = 123; 
				$this->_result['data'][]       = $this->code[123];
				
				return $this->_result;
		}
			
		$record = $this->find_by($this->param['id']);
		if(!empty($record)){
			if($record['tac'] != $this->param['tac']){
				$this->_result['status']     = 'error'; 
				$this->_result['error_code'][] = 124; 
				$this->_result['data'][]       = $this->code[124]; 
			}
			
		}else{
			//Invalid User
			$this->_result['status']     = 'error'; 
			$this->_result['error_code'][] = 114; 
			$this->_result['data'][]       = $this->code[114]; 
		}
		return $this->_result;	
	}
	
	public function updateContestantWithField($field){
		
		if($field == "slogan"){
			$slogan	= !empty($this->param['slogan']) ? $this->param['slogan'] : ""; 
			if(!$slogan){
				$this->_result['status']     = 'error'; 
				$this->_result['error_code'][] = 118; 
				$this->_result['data'][]       = $this->code[118];
				
				return $this->_result; 
			}else if(strlen($slogan) > $this->config->item('slogan_max')){
				$this->_result['status']     = 'error'; 
				$this->_result['error_code'][] = 119; 
				$this->_result['data'][]       = $this->code[119];
				
				return $this->_result;
			}
		}
		
		$data = array(
				$field		=> $this->param[$field],
				'updated'	=> localDate(),
		);
 
		$this->update($this->param['id'], $data);
		$this->_result['status']     = 'success'; 
		$this->_result['data']       = $this->param['id'];
		
		return $this->_result;
	}
	
	 
	
	/*********************************************
	******************* ADMIN ********************
	*********************************************/
	public function admin_getList($sortby,$page="", $purpose=""){
		// Search Param
		$search = '';						
		if ($this->input->get('q')) {				
			$srhs = explode(' ',$this->input->get('q'));
			foreach($srhs as $srh){
				$search .= (!empty($search) ? " and ": "");		
				$search .= "(name like '%".$srh."%' OR mobile like'%".$srh."%'  OR email like'%".$srh."%' OR ic like'%".$srh."%' OR slogan like'%".$srh."%')  ";			
			}
		}
		
		if(!empty($this->param['state'])) {
			$search .= (!empty($search) ? " and ": "");					
			$search .= "state = '".$this->param['state']."' ";
		}
			 
		$return   = convert_sort($this->sorted,$sortby,$this->primary_key);
		$new_sort = change_sort($return['sort']);	
	 	$offset   = pageToOffset($this->config->item('per_page'),$page);
	  
		// Load Data
		$data['results'] = $this->get_data($search,$this->config->item('per_page'),$offset,$return['order'],$return['sorts']); 
		
		if($purpose == "slogan"){
			$list = array();
			foreach($data['results'] as $k => $val){
				$list[$val['ic'].$val['mobile']]['name'] = $val['name'];
				$list[$val['ic'].$val['mobile']]['mobile'] = $val['mobile'];
				$list[$val['ic'].$val['mobile']]['email'] = $val['email'];
				$list[$val['ic'].$val['mobile']]['ic'] = $val['ic'];
				$list[$val['ic'].$val['mobile']]['slogan'][] = $val['slogan'];
	 			
			} 
			$data['results'] = $list; 
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
		$name	  = !empty($this->param['name']) ? $this->param['name'] : ""; 
		$ic		  = !empty($this->param['ic']) ? $this->param['ic'] : ""; 
		$mobile	= !empty($this->param['mobile']) ? $this->param['mobile'] : ""; 
		$email	= !empty($this->param['email']) ? $this->param['email'] : ""; 
		$state	= !empty($this->param['state']) ? $this->param['state'] : ""; 
		$agreement	= !empty($this->param['agreement']) ? $this->param['agreement'] : ""; 
		$tnc		= !empty($this->param['tnc']) ? $this->param['tnc'] : ""; 
		$tac		= !empty($this->param['tac']) ? $this->param['tac'] : ""; 
		
		$statusCode = array();
		if(!$name){
			$statusCode[] = 115;
		}
		if(!$ic){
			$statusCode[] = 116;
		}
		if(!$mobile){
			$statusCode[] = 117;
		}
		if(!$email){
			$statusCode []= 101;
		}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		    $statusCode[] = 105;
		}
		if(!$state){
			$statusCode[] = 113;
		}
		if(!$agreement){
			$statusCode[] = 121;
		}
		if(!$tnc){
			$statusCode[] = 122;
		}
//		if(!$tac){
//			$statusCode[] = 123;
//		} 
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
