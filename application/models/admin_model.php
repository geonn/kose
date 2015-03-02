<?php
class Admin_Model extends APP_Model{

	function __construct() {
		$this->_table      = "admin";
		$this->primary_key = 'admin_id';	
	}
	
	public function getAdminInfo($id){
		$filter = array($this->primary_key=> $id);
		$result = $this->get_data($filter);
		return $result;
	}
	
	public function checkGeneralPermission($module){
		$res = $this->permissions_model->checkExists($this->user->get_memberrole(), $module);
		if($res[0]['permission'] > 2){ 
			return 1;
		}else{
			return 0;
		}
	}
	
	/** Get admin user information in listin **/
	public function getAdminUserList($sortby){
		
		$admin = new AdminDM();
		
		// Search Param
		$search = '';
		if ($this->input->get('role')) {
			$admin->where('role', $this->input->get('role'));
		}
		
		if ($this->input->get('q')) {
			$admin->like('email', $this->input->get('q'));			
			$admin->like('login', $this->input->get('q'));			
		}		
		
		if ($this->input->get('status')) {
			$admin->where('status', $this->input->get('status'));
		}
		$offset = pageToOffset($this->config->item('per_page'),$this->uri->segment(4));
		$return   = convert_sort($this->sorted,$sortby,'admin_id');
		$new_sort = change_sort($return['sort']);		
		
		/** LIMIT **/						
		$admin->limit($this->config->item('per_page'),$offset);
		
		/** ORDER **/
		$admin->order_by($return['order'],$return['sorts']);
		
		/** RETRIEVE RECORDS **/
		$admin->get();
		
		// Load Data
		$data['roles'] =  array_merge(array(''=>'- Select Role -'), $this->roles);
		
		foreach ($admin as $ad) {
        	$data['results'][] = object_to_array($ad->stored); 
        }
		$data['count']   = $this->admin_model->total_count($search);
		$data['new_sort'] = $new_sort;
		
		$admin->clear();
		return $data;
	}
	
	public function getDashboardReport(){
		$data['totalLocation']     = 0 ;
		$data['last2daysLocation'] = 0 ;
		$data['totalUsers']        = 0 ;
		$data['last2daysUsers']    = 0 ;
		
		/* Get location report */
		$query = $this->db->query('CALL getLocationByDate()');
		$locationRpt = $query->result_array();
		$query->next_result();		
		
		$yesterday = date('Y-m-d',strtotime("-1 days"));		
		foreach($locationRpt as $k => $val){
			$data['totalLocation'] += $val['total'];
			if($yesterday <= $val['date']){
				$data['last2daysLocation'] += $val['total'];
			}
		}
		
		/* Get User report */
		$query = $this->db->query('CALL getUsersByDate()');
		$usersRpt = $query->result_array();	
		$query->next_result();		
		foreach($usersRpt as $k => $val){
			$data['totalUsers'] += $val['total'];
			if($yesterday <= $val['date']){
				$data['last2daysUsers'] += $val['total'];
			}
		}
		
		return $data;
	}
	
	public function generateAddButton($module){
		$res = $this->permissions_model->checkExists($this->user->get_memberrole(), $module);
		if($res[0]['permission'] > 2){ 
			echo '<button type="submit" value="Submit" ><span><span>'. $this->config->item("icon_add") .'Add New </span></span></button>';
		}
	}
	
	public function generateUpdateButton($module,$id=""){
		$res = $this->permissions_model->checkExists($this->user->get_memberrole(), $module);
		if($res[0]['permission'] > 2){ 
			echo '<button type="submit" id="submitformbutton"><span><span>'.$this->config->item("icon_edit") .'Update</span></span></button>';	
		}else if($module == "admin" && ($this->user->get_memberid() == $id)){				
			echo '<button type="submit" id="submitformbutton"><span><span>'.$this->config->item("icon_edit") .'Update</span></span></button>';	

		}
	}
	

	public function generateEditButton($function,$id,$module){
		$res = $this->permissions_model->checkExists($this->user->get_memberrole(), $module);		
		if($res[0]['permission'] > 1){	
			echo '<button  onclick="location.href=\''.$this->config->item('admin_url') .'/'.$function.'/edit/'.$id.'\';"><span><span>'.$this->config->item("icon_edit") .'Edit</span></span></button>';			
		}else if($module == "admin" && ($this->user->get_memberid() == $id)){				
				echo '<button  onclick="location.href=\''.$this->config->item('admin_url') .'/'.$function.'/edit/'.$id.'\';"><span><span>'.$this->config->item("icon_edit") .'Edit</span></span></button>';	
		}
	}
	
	public function generateDetailsButton($function,$id,$module){
		$res = $this->permissions_model->checkExists($this->user->get_memberrole(), $module);		
		if($res[0]['permission'] > 1){	
			echo '<button  onclick="location.href=\''.$this->config->item('admin_url') .'/'.$function.'/details/'.$id.'\';"><span><span>Details</span></span></button>';			
		}else if($module == "admin" && ($this->user->get_memberid() == $id)){				
				echo '<button  onclick="location.href=\''.$this->config->item('admin_url') .'/'.$function.'/details/'.$id.'\';"><span><span>Details</span></span></button>';	
		}
	}
	
	public function generateEditImagesButton($function,$id,$module){
		$res = $this->permissions_model->checkExists($this->user->get_memberrole(), $module);		
		if($res[0]['permission'] > 1){
			echo '<button id="img'.$id.'" class="gallery_stalk" onclick="return clickIn(\''.$id.'\');"><span><span>'.$this->config->item("icon_edit") .'Edit</span></span></button>';						
		}
	}
	
	public function generateCustomButton($text, $module="", $function="", $id=""){
		echo ' <button onClick="location.href=\''.$this->config->item('admin_url').'/'.$module.'/'.$function.'/'.$id.'\'" ><span><span>' . $text .'</span></span></button>  ';
	
	}
	
	public function generateDeleteButton($function,$id,$module){
		$res = $this->permissions_model->checkExists($this->user->get_memberrole(), $module);
		
		if($res[0]['permission'] == 3){ 
			echo '<button  value="Delete" onclick="return confirmRemove(\''.$id.'\');" href="javascript:void(0)"><span><span>'.$this->config->item("icon_cross") .'Delete</span></span></button>';	;
		}
	}
		
	public function generateFilterButton(){
		echo ' <button type="submit" value="Submit "><span><span>' . $this->config->item("icon_search") .' Filter </span></span></button>  ';
	}
	
	public function generateGenerateButton(){
		echo ' <button type="submit" value="Submit "><span><span>' . $this->config->item("icon_search") .' Generate </span></span></button>  ';
	}
	
	public function generateLoading(){
		echo '<div id="loading" name="loading" align="center"><br/><br/><br/>' . $this->config->item("img_loading") . '<br/><br/></div>';
	}
	
	public function generateGoToTop(){
		echo '<div id="go_top" class="goToTop"><a id="scrollTop">' . $this->config->item('icon_gotop') . '</a></div>';
	}
}
 

?>
