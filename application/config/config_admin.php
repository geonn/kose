<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();	
$CI->config->load('config');   
$this->domain = $CI->config->item('domain'); 

$config['roles'] = array(
	 'admin'  => "Administrator",
	 'master' => "Master" 
);

$config['menu'] = array(
	 'users'     => array(
	 					"name" => "Users",	
	 					"url" => $this->domain."/admin/users/index",	
	 				),
	 'contestant'  => array(
	 					"name" => "Contestants",	
	 					"url" => $this->domain."/admin/contestant/index",	
	 				),
	 
	 'settings'    => array(
	 					"name" => "Settings",	
	 					"url" => $this->domain."/admin/permissions/index",	
	 				),
);

$config['sub_menu'] = array(
	 
	 'users'     => array(
	 					'Users List' => $this->domain.'/admin/users/index'
	 				),	
	'contestant'     => array(),	
	 
	 'settings'    => array(
	 				 
	 					'Permission' => $this->domain.'/admin/permissions/index'
	 	),
);

$config['admin_option'] = array(
	 '0'  => "No Access",
	 '1'  => "View Listing",
	 '2'  => "View and Edit",	
	 '3'  => "ALL (Listing, Add, Edit, Delete)",
);

$config['account_status'] = array(
	1 => 'Active',
	2 => 'Inactive',
);							

$config['gender'] = array(
	'm' => 'Male',
	'f' => 'Female',
);	
$config['sorted']  = array(
	1 =>'ASC',
	2 =>'DESC'
);
 
/* End of file config_admin.php */
/* Location: ./application/config/config_admin.php */
