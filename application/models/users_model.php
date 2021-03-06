<?php
class Users_Model extends APP_Model{
	public $_result = array();
	public $code = array();
	function __construct() {
		$this->_table      = "users";
		$this->primary_key = 'u_id';	
		
		$this->_result['status']     = '';
		$this->_result['error_code'] = '';
		$this->_result['data']       = array();
		$this->code = $this->config->item('api_code');	
	}
	
	/** Retrieve user base on their info  **/
	public function getUser(){
		$result     =$this->user_sessions_model->checkUserSession();
			
		if($result) {
			
			$user = $this->get_data(array($this->primary_key => $result));
 
			
			$this->_result['status']     = 'success';
			$this->_result['data']       = $user[0];	
		} else {
			$this->_result['status']     = 'error';
			$this->_result['error_code'] = 100;
		}		
		
		return $this->_result;
	}
	 
	public function getUserById($u_id){
		$filter = array(
					$this->primary_key    => $u_id
				  );
		$users   = $this->get_data($filter);
		
		return $users[0];
	}
	
	/** Authenticate and login user**/
	public function loginUser(){
		
		$filter = array(
					'username'    => trim($this->param['username']),
					'password' => md5($this->param['password'])
				  );
		$users   = $this->get_data($filter);
		$result  = "";
		
		if($users){			
			
			if($users[0]['status'] == 2){
				$this->_result['status']     = 'error';
				$this->_result['error_code'] = array(101);
				$this->_result['data']       = array($this->code[101]);
			}else{
				
				$this->_result['status']     = 'success';
				$this->_result['data']       = $this->generateSession($users[0]['u_id']);	
				
				// Set user object
				foreach($users as $info){				
					$this->user->set_memberid($info['u_id']);
					$this->user->set_memberemail($info['email']);
					$this->user->set_memberusername($info['username']);
					$this->user->set_memberrole($info['roles']);
				}
				
			}
			
		}else{
			
			$this->_result['status']     = 'error';
			$this->_result['error_code'] = array(135);
			$this->_result['data']       = array($this->code[135]);
		}
		
		return $this->_result;
	}
	
	 
	/** Logout User ***/
	public function logoutUser(){
		$u_id = $this->user_sessions_model->removeUserSession();
		$data = array(
			'last_login' 	 => date('Y-m-d H:i:s'),
		);				
		$this->update($u_id,$data);
		$this->phpsession->clear(null,'key');
		$this->phpsession->clear(null,'uid'); 
		 
		$this->_result['status']     = 'success';
		return $this->_result;
	}
	
	/** Add user to DB  **/
	public function addUser(){
		$validation = $this->validateUser();
		
		$result     = $this->checkUser(); 
		if(empty($validation)) { 
			if(empty($result)) {
				$data = array(
					'fullname'=> $this->param['fullname'], 
					'email'    => $this->param['email'],
					'username'=> $this->param['username'],  
					'password' => md5($this->param['password']), 
					'roles'		 => $this->param['roles'], 
					'status'   => !empty($this->param['status']) ? $this->param['status'] : 1,
					'created' 	 => localDate(),
					'updated' 	 => localDate(),
				);
				$id = $this->insert($data);
				
			
				$this->_result['status']     = 'success';
				$this->_result['data']       = $this->generateSession($id);
				
			} else { 
				$this->_result['status']     = 'error';
				$this->_result['error_code'] = 102;
				$this->_result['data'] = $this->code[102];
			}
		} else { 
			
				$this->_result['status']     = 'error';
				$this->_result['error_code'] = $validation;
				foreach($validation as $k => $val){
					$this->_result['data'][$k] = $this->code[$val];
				}
			
		}
		
		return	$this->_result;
	}
	
	public function editAccount(){
		$validation = $this->validateUser();
		$result     = $this->checkUser(); 
		$this->_result['data'] = "";
		if(empty($validation)) { 
			if(empty($result)) {
				$data = array(
					'fullname'=> $this->param['fullname'], 
					'roles' => $this->param['roles'],
					'email'    => $this->param['email'],  
					'status' => $this->param['status'],
					'updated' 	 => localDate(),
				);
			 
				$id = $this->update($this->param['u_id'],$data);
				$this->_result['status']     = 'success';
				
			} else {  
				$this->_result['status']     = 'error';
				$this->_result['error_code'] = 102;
				$this->_result['data'] = $this->code[102];
			}
		
		} else { 
			$this->_result['status']     = 'error';
			$this->_result['error_code'] = $validation;
			foreach($validation as $k => $val){
				$this->_result['data'][$k] = $this->code[$val];
			}
			
		}
		
		return	$this->_result;
	}
	
	/**Generate session to user **/
	private function generateSession($u_id){
		$result = $this->user_sessions_model->addUserSession($u_id);
		if($result){
			$data = array(
				'last_login' 	 => localDate(),
		   	);				
			$this->update($u_id,$data);
		}
		
		return $result;
	}
  
	public function doForgotPassword(){
		if(!$this->param['email']){
			$statusCode = 104;
		}else if (!filter_var($this->param['email'], FILTER_VALIDATE_EMAIL)) {
		    $statusCode = 105;
		}
		
		if(!empty($statusCode)){
			$this->_result['status']     = 'error';
			$this->_result['error_code'] = $statusCode;
			$this->_result['data']       = $this->code[$statusCode];
		}else{
			$result = $this->sendCodeForgotPassword();
			$this->_result['status']     = 'success';
			$this->_result['data']       = $result;
		}
		
		return $this->_result;
			
	}
	
	/** send user an email regarding reset Forgot password **/
	public function sendCodeForgotPassword(){		
		$filter = array('u_email' => $this->param['email']);
		$res = $this->get_data($filter);
		
		if($res){
			$code  = $data['code'] = substr(GUID(),2,6);
			$data['name'] =  $res[0]['u_nickname'];
			$codeRes = $this->user_tempcode_model->addUserCode($res[0]['u_id'],$code);
			if($codeRes === 1){
				
				//Send email			
				$this->email->initialize(array('mailtype'=>'html'));				
				$this->email->from($this->config->item('project_email'), $this->config->item('project_admin'));
				$this->email->to($this->param['email']); 				
				$this->email->subject('Verification Code');
				$this->email->message($this->load->view('/admin/email/forgotPassword',$data,true));					
				$this->email->send();
				
				$this->_result['status']     = 'success';
			}else{
				$this->sendCodeForgotPassword();	
			}			
		}else{
			$this->_result['status']     = 'error';
			$this->_result['error_code'] =  114;	
			$this->_result['data']       = 'Your email is not exists in our system.';
		}
		
		return $this->_result;
	}
	
	/** Validate verification code from forgot password module **/
	public function validateCode(){
		if(!empty($this->param['email']) && !empty($this->param['code'])){
			$filter = array('email' => $this->param['email']);
			$user   = $this->get_data($filter);
			$return = array();
			if($user){
				$res = $this->user_tempcode_model->checkCode($user[0]['u_id'], $this->param['code']);
				
				if($res === 1){
					$key = $this->user_tempcode_model->addUserTempSession($this->param['code']);
					$this->_result['status']     = 'success';
					$this->_result['data']    = $key;
				}else{
					$this->_result['status']     = 'error';
					$this->_result['error_code'] = $res;
					$this->_result['data'] = $this->code[$res];
				}
			}else{
				$this->_result['status']     = 'error';
				$this->_result['error_code'] = 114;
				$this->_result['data'] = $this->code[114];
			}
		}else{
			$this->_result['status']     = 'error';
			$this->_result['error_code'] = 132;
			$this->_result['data'] = $this->code[132];
		}
		
		return $this->_result;	
	}
	
	public function changePassword(){
		$result     = $this->checkUser();				
		if($result) {
		
			if(md5($this->param['oldPwd']) == $result[0]['u_password']){
				$data = array(
					'password' => md5($this->param['newPwd']),
					'updated'    => localDate(),
				);				
				$this->update($this->param['u_id'],$data);
				$this->_result['status']     = 'success';
			}else{
				$this->_result['status']     = 'error';
				$this->_result['error_code'] = 129;
			}
			
		} else {
			$this->_result['status']     = 'error';
			$this->_result['error_code'] = 100;
		}		
		
		return $this->_result;
		
	}
	
	public function changeNewPassword(){
		$result = $this->checkPassword();
		if($result['status'] == 'error'){
			return $result;
		}
		
		if(empty($this->param['tempses'])){
			$this->_result['status']     = 'error';
			$this->_result['error_code'] =  108;
			$this->_result['data'] = $this->code[108];
			return $this->_result;
		}
		
		$u_id = $this->user_tempcode_model->getUserId($this->param['tempses']);
		$filter = array($this->primary_key => $u_id);
		$res = $this->get_data($filter);
		
		if($res){
			$data = array(
				'password' => md5($this->param['password']),
				'updated'    => localDate(),
			);				
			$this->update($u_id,$data);
			$this->_result['status']  = 'success';
		}else{
			$this->_result['status']     = 'error';
			$this->_result['error_code'] =  100;
			$this->_result['data'] = $this->code[100];
		}
		
		return $this->_result;
	}
	
	 
	/*********************************************
	******************* ADMIN ********************
	*********************************************/
	public function admin_getListUsers($sortby,$page=""){
	
		// Search Param
		$search = '';						
		if ($this->input->get('q')) {				
			$srhs = explode(' ',$this->input->get('q'));
			foreach($srhs as $srh){
				$search .= (!empty($search) ? " and ": "");		
				$search .= "(fullname like '%".$srh."%' OR username like'%".$srh."%' OR email like '%".$srh."%' OR ".$this->primary_key."='".$srh."')  ";			
			}
		}
			
		if ($this->input->get('status')) {
			$search .= (!empty($search) ? " and ": "");					
			$search .= "status = '".$this->input->get('status')."' ";
		}
	 
		$return   = convert_sort($this->sorted,$sortby,$this->primary_key);
		$new_sort = change_sort($return['sort']);	
	 	 $offset   = pageToOffset($this->config->item('per_page'),$page);
	  
		// Load Data
		$data['results'] = $this->get_data($search,$this->config->item('per_page'),$offset,$return['order'],$return['sorts']); 
				 
		$data['count']   = $this->total_count($search);
		$data['new_sort'] = $new_sort;
		
		// Pagination		
		$config['base_url'] = $this->config->item('admin_url').'/'.$this->name.'/index/';	
		$config['total_rows'] = $data['count'];
		$this->pagination->initialize($config);		
		
		return $data;
	}
	
	public function checkPassword(){
		if(isset($this->param['password']) && isset($this->param['password2'])){
			if(empty($this->param['password']) || empty($this->param['password2'])){ 
				$this->_result['status']     = 'error';
				$this->_result['error_code'] =  106;
				$this->_result['data'] = $this->code[106];
				return $this->_result;		
			}
			
			if($this->param['password'] != $this->param['password2']){ 
				$this->_result['status']     = 'error';
				$this->_result['error_code'] =  107;
				$this->_result['data'] = $this->code[107];
				return $this->_result;		
			}
			
		}
		$this->_result['status']     = 'success';
		return $this->_result;		
	}
	
	/*********************************************
	******************* PRIVATE CLASS ************
	*********************************************/
 
	/** Check if userdata is exists  **/
	private function validateUser(){
		$fullname  = isset($this->param['fullname'])  ? trim($this->param['fullname'])  : "";
		$username  = isset($this->param['username'])  ? trim($this->param['username'])  : "";
		$email = isset($this->param['email']) ? trim($this->param['email']) : "";
		$password  = isset($this->param['password'])   ? trim($this->param['password'])   : "";
		$confirmation  = isset($this->param['password2'])   ? trim($this->param['password2'])   : "";
		
		$statusCode = array();
		if(!$fullname){
			$statusCode[] = 104;
		}
		if(!$username){
			$statusCode[] = 103;
		}
		if(!$email){
			$statusCode []= 101;
		}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		    $statusCode[] = 105;
		}
		
		if( !empty($this->param['edit'])){
			if($this->param['edit'] == 1 &&  $this->param['change_password'] == '1'){
				
				if(empty($this->param['current_password'])){
					$statusCode[] = 128;
				}else{
					$filter = array(
						'u_id'       => $this->u_id,
						'password' => md5($this->param['current_password'])
					);
					$validateUser = $this->get_data($filter);
					if(empty($validateUser)){
						$statusCode[] = 129;
					}
				}
				
			} 
		}
		
		if(!$password){
			$statusCode[] = 106;
		}elseif($password != $confirmation){
			$statusCode[] = 107;	
		}
			
		return $statusCode;
	}
	
	/** Check if user registered before/Duplicate ?  **/
	private function checkUser(){
		
		if($this->param){
			if(isset($this->param['u_id']) && !empty($this->param['u_id'])){ 
				$filter = array($this->primary_key => $this->param['u_id']);
			} elseif( !empty($this->param['edit']) && $this->param['edit'] == 1) {
				$result = $this->user_sessions_model->checkUserSession();
				if($result) {
					$user = $this->get_data(array($this->primary_key => $result));
					$filter = "(email !='". $user[0]['email']. "' AND email='" . $this->param['email'] . "')";
				}
			} else {
				$filter = array('email' => $this->param['email']);
			}
		
			$result = $this->get_data($filter);//param : $where,$limit,$offset, $order, $direction('ASC','DESC')	
			if(!empty($result )){
				foreach($result as $k => $val){
					if($val['u_id'] != $this->param['u_id']){
						return $result;
					}else{
						return "";	
					}
				}
			}else{
				return "";	
			}
			
		}
		
		return false;
	}
	
}
?>
