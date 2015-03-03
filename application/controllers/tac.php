<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tac extends Web_Controller {

	/** Module name **/
	public $name        = 'tac';	
	function __construct() {
		parent::__construct();	
	}
	
	public function index($key){
		$data['key'] = $key;    
		$data['info'] =$this->contestant_model->find_by(decode_key($key));
 
		$this->_render_form('index',$data);
	}
	
	public function requestTac($key){ 
	
		$this->param['id'] = decode_key($key);
		$this->param['tac'] = tac_generator(); 
		$info = $this->contestant_model->find_by(decode_key($key));
		$result = $this->contestant_model->updateContestantWithField('tac');
		
		$isZero = substr($info['mobile'],0,1);
		if($isZero == "0"){
			$info['mobile'] = "6".$info['mobile'];
		}	  
		$this->sendSMS($info['mobile'],$this->param['tac']);
		
		echo generate_json($result);	 
	}
	
	public function submitTac($key){ 
 
		$this->param['id'] = decode_key($key);  
		$result = $this->contestant_model->validateTac();	  
		echo generate_json($result);	 
	}
	
	public function sendSMS($mobile, $tac){
		
		$text = "KOSE Malaysia: TAC requested for Submission. TAC: ".$tac."  Thank you and good luck.";
		$url  = "http://api.gosms.com.my/eapi/sms.aspx";
	 
		$fields = array(
						'company' => urlencode(SMS_COMPANY),
						'user' => urlencode(SMS_USER),
						'password' => SMS_PASSWORD,
						'gateway' => urlencode(SMS_GATEWAY),
						'mode' => 'BUK',
						'type' => 'TX',
						'hp' => urlencode($mobile),
						'mesg' => urlencode($text),
						'charge' => 0,
						'convert' => 0
				);

	 	//url-ify the data for the POST
	 	$fields_string="";
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
 		$url .= "?".$fields_string;
//		/*** INIT CURL *******************************************/
//		$curlObj    = curl_init();
//		  
//		/*** SEND PUSH ******************************************/
//		curl_setopt_array($curlObj, array(
//				CURLOPT_URL => "http://api.gosms.com.my/eapi/sms.aspx?company=".SMS_COMPANY."&user=".SMS_USER."&password=".SMS_PASSWORD."&gateway=".SMS_GATEWAY."&mode=BUK&type=TX&hp=".$mobile."&mesg=".$text."&charge=0&convert=0", 
//		    CURLOPT_RETURNTRANSFER => true,  
//	      CURLOPT_POST => 1,
//	      CURLOPT_POSTFIELDS  =>  "company=".SMS_COMPANY."&user=".SMS_USER."&password=".SMS_PASSWORD."&gateway=".SMS_GATEWAY."&mode=BUK&type=TX&hp=".$mobile."&mesg=".$text."&charge=0&convert=0",
//	      CURLOPT_FOLLOWLOCATION  =>  1,
//	      CURLOPT_TIMEOUT => 60
//		)); 
//		$session = curl_exec($curlObj);     
//		 print_pre("http://api.gosms.com.my/eapi/sms.aspx?company=".SMS_COMPANY."&user=".SMS_USER."&password=".SMS_PASSWORD."&gateway=".SMS_GATEWAY."&mode=BUK&type=TX&hp=".$mobile."&mesg=".$text."&charge=0&convert=0");
//		print_pre($session);
//		/*** THE END ********************************************/
//		curl_close($curlObj);
//		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		//curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */