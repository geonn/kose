<?php 
if (! defined('BASEPATH')) exit('No direct script access');

class Contestant extends Admin_Controller {
	public $denied   = false; 
	public $name  = 'contestant';
	      			
	function __construct() {
		parent::__construct();	 
		$res = $this->permissions_model->checkExists($this->user->get_memberrole(), $this->name);
		if($res[0]['permission'] < 1){ 
			$this->denied = TRUE;
		}
	}
	
	/***Contestant list***/
	function index($sortby='',$page='1') {
		//Initialize param
	 
		$data['page']=$page;
		if(empty($page)) $data['page']="1";					
		$data['sortby']   = !empty($sortby) ? $sortby : "id-1"; 
		$data['search'] =!empty($this->param['q']) ? $this->param['q'] : "";
		$data['state'] = !empty($this->param['state']) ? $this->param['state'] : "";
		
		// 	Build it!
		$this->_render_form('index',$data);
	}
	
	function get_list( $page='1', $sortby=''){ 
		$data = $this->contestant_model->admin_getList($sortby,$page);  
		$table_row = $this->load->view('/admin/'.$this->name.'/_list_table',$data,true);
		echo $table_row;
	}
	
 	
 	/***Slogan list***/
	function slogan($sortby='',$page='1') {
		//Initialize param
	 
		$data['page']=$page;
		if(empty($page)) $data['page']="1";					
		$data['sortby']   = !empty($sortby) ? $sortby : "id-1"; 
		$data['search'] =!empty($this->param['q']) ? $this->param['q'] : "";
		$data['state'] = !empty($this->param['state']) ? $this->param['state'] : "";
		
		// 	Build it!
		$this->_render_form('slogan',$data);	
	}
	 
	function get_slogan_list( $page='1', $sortby=''){ 
		$data = $this->contestant_model->admin_getList($sortby,$page,"slogan");  
		$table_row = $this->load->view('/admin/'.$this->name.'/_slogan_table',$data,true);
		echo $table_row;
	}
	
	/***Lucky draw list***/
	function luckyDraw($sortby='',$page='1') {
		//Initialize param
	 
		$data['page']=$page;
		if(empty($page)) $data['page']="1";					
		$data['sortby']   = !empty($sortby) ? $sortby : "id-1"; 
		$data['search'] =!empty($this->param['q']) ? $this->param['q'] : "";
		$data['state'] = !empty($this->param['state']) ? $this->param['state'] : "";
		
		// 	Build it!
		$this->_render_form('luckyDraw',$data);	
	}
	
	function get_luckyDraw_list( $page='1', $sortby=''){ 
		$data = $this->voucher_model->admin_getList($sortby,$page);  
		$table_row = $this->load->view('/admin/'.$this->name.'/_luckyDraw_table',$data,true);
		echo $table_row;
	}
 
 	function downloadContestantList($page='1', $sortby=''){
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=contestant_'.localDate().'.csv');
		
		 $data =  $this->contestant_model->admin_getList($sortby,$page);  	
		  
		 $path =  getcwd()."/public/reports/contestant_".localDate().".csv";
		 $file = fopen('php://output' ,"a+");
		 $list = array();
		 $str = "";
		 $title[0] = array(
		 	'name'   => 'Name',
		 	'ic'     => 'Identity Card',
		 	'mobile' => 'Mobile No', 
		 	'email'  => 'Email',
		 	'state'  => 'State',
		 	'date'  => 'Played Date',
		 	'slogan' => 'Slogan',
		  );
		 foreach ($title as $fields) {
		    fputcsv($file, $fields);
		 }
		
		 foreach ($data['results'] as $k => $val) {
		  
			$list[$k]['name'] = $val['name'];
			$list[$k]['ic'] = $val['ic'];
			$isZero = substr($val['mobile'],0,1);
		 	if($isZero == "0"){
		 		$list[$k]['mobile'] = "+6".$val['mobile'];
		 	}else{
		 		$list[$k]['mobile'] = $val['mobile'];
		 	}
		 	 
			$list[$k]['email'] = $val['email'];
			$list[$k]['state'] = match($val['state'], $this->config->item('state'));
			$list[$k]['created'] =  date_convert($val['created'], 'full'); 
			$list[$k]['slogan'] = $val['slogan']; 
		 }
		
		foreach ($list as $fields) {
		    fputcsv($file, $fields);
		}
	  
	  fclose($file);
	}
	
	function downloadSloganList($page='1', $sortby=''){
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=slogan_'.localDate().'.csv');
		
		 $data =  $this->contestant_model->admin_getList($sortby,$page,"slogan");  	
		  
		 $path =  getcwd()."/public/reports/slogan_".localDate().".csv";
		 $file = fopen('php://output' ,"a+");
		 $list = array();
		 $str = "";
		 $title[0] = array(
		 	'name'   => 'Name',
		 	'ic'     => 'Identity Card',
		 	'mobile' => 'Mobile No', 
		 	'email'  => 'Email',
		 	'slogan' => 'Slogan',
		  );
		 foreach ($title as $fields) {
		    fputcsv($file, $fields);
		 }
		
		 foreach ($data['results'] as $k => $val) {
		  
			$list[$k]['name'] = $val['name'];
			$list[$k]['ic'] = $val['ic'];
			$isZero = substr($val['mobile'],0,1);
		 	if($isZero == "0"){
		 		$list[$k]['mobile'] = "+6".$val['mobile'];
		 	}else{
		 		$list[$k]['mobile'] = $val['mobile'];
		 	}
		 	
			
			$list[$k]['email'] = $val['email'];
			
			$text = "";
			if(is_array($val['slogan'])){
				$count = 1; 
				foreach( $val['slogan'] as $d => $dal){
					$text .= $count.") ". $dal."\r\n";
					$count++;
				} 
			}
			$list[$k]['slogan'] = $text;
		 }
		
		foreach ($list as $fields) {
		    fputcsv($file, $fields);
		}
	  
	  fclose($file);
	}
	
	function downloadLuckyDrawList($page='1', $sortby=''){
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=luckyDraw_'.localDate().'.csv');
		
		 $data =  $this->voucher_model->admin_getList($sortby,$page);  	
		  
		 $path =  getcwd()."/public/reports/luckyDraw_".localDate().".csv";
		 $file = fopen('php://output' ,"a+");
		 $list = array();
		 $str = "";
		 $title[0] = array(
		 	'name'   => 'Name',
		 	'ic'     => 'Identity Card',
		 	'mobile' => 'Mobile No', 
		 	'email'  => 'Email',
		 	'state'  => 'State',
		 	'prize'  => 'Prize',
		 	'date'   => 'Date Won',
		  );
		 foreach ($title as $fields) {
		    fputcsv($file, $fields);
		 }
		
		 foreach ($data['results'] as $k => $val) {
		  
			 $list[$k]['name'] = $val['name'];
			 $list[$k]['ic'] = $val['ic'];
			 $isZero = substr($val['mobile'],0,1);
		 	 if($isZero == "0"){
		 	 	$list[$k]['mobile'] = "+6".$val['mobile'];
		 	 }else{
		 	 	$list[$k]['mobile'] = $val['mobile'];
		 	 }
		 	 
			 $list[$k]['email'] = $val['email'];
			 $list[$k]['state'] = match($val['state'], $this->config->item('state'));
			 $list[$k]['prize'] = $val['prize'];
			 $list[$k]['date'] = date_convert($val['created'],'full');
		 }
		
		foreach ($list as $fields) {
		    fputcsv($file, $fields);
		}
	  
	  fclose($file);
	}
	
	
	function show(){
		$this->message->set('Record updated!', 'error',TRUE);	
		redirect($this->config->item('admin_url').'/main/index');
	}
	
	
}