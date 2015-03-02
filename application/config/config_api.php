<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//
//API AUTH Key
//
$config['api_key'] = array(
	'webadmin'   => '981bce3f4b506c6eb5473debb3275c27',
	'biomas'     => '06b53047cf294f7207789ff5293ad2dc',
);
//
//API AUTH Param
//
$config['api_param'] = array(
	'user' , 'key'
);
//
//API Return code message
//
$config['api_code'] = array(
	  1	  => 'Success',
	100	  => 'No Result',
	101   => 'Empty email',
	102   => 'Duplicate',
	103   => 'Empty username',
	104   => 'Empty full name',
	105   => 'Invalid email',
	106   => 'Empty password',
	107   => 'Both password must same',
	108   => 'Empty tempses',
	109   => 'Invalid verification code',
	110   => 'Empty weekend working hours',
	111   => 'Empty order destination area',
	112   => 'Empty order destination location',
	113   => 'Empty contestant state',
	114   => 'No user',
	115   => 'Empty contestant name',
	116   => 'Empty contestant identity card number',
	117   => 'Empty contestant mobile number',
	118   => 'Empty slogan',
	119   => 'Slogan length exceeded',
	120   => 'Exceeded participantion amount',
	121   => 'You must agree to be contacted by KOSE Malaysia if necessary',
	122   => 'You must agreed to the Terms & Conditions',
	123   => 'Empty TAC',
	124   => 'TAC is incorrect',
	125   => 'Empty favourite',
	126   => 'Already in favourites list',
	127   => 'Empty favourite id',
	128   => 'Missing latitude or longitude',
	129   => 'Wrong password',
	130   => 'Already activated',
	131   => 'Expired verification code',
	132   => 'Missing params email or code',
	135   => 'Login fail',
	136   => 'User is not active',
	137   => 'Empty sender name',
	138   => 'Empty sender contact number',
	139   => 'Empty sender address',
	140   => 'Empty sender city',
	141   => 'Empty sender postcode',
	142   => 'Empty sender state',
	143   => 'Empty receiver name',
	144   => 'Empty receiver contact number',
	145   => 'Empty receiver address',
	146   => 'Empty receiver city',
	147   => 'Empty receiver postcode',
	148   => 'Empty receiver state',
	160   => 'No session param passed.',	
	162	  => 'Can\'t retrieved user session. Please login again.',
	170   => 'User is banned for review',
	180   => 'Unknown error. Could be connection problem or server down.',
	188	  => 'User param or API key param is missing',
	190	  => 'Invalid user',
	192	  => 'Wrong user key provided',
	
);
 
//
//State
//
$config['state'] = array( 
	'jh' => 'Johor',
	'kd' => 'Kedah',
	'kt' => 'Kelantan',
	'kv' => 'Klang Valley', 
	'ml' => 'Melaka',
	'ns' => 'Negeri Sembilan', 
	'ph' => 'Pahang',	
	'pn' => 'Penang',	
	'pr' => 'Perak',
	'ps' => 'Perlis',
	'sb' => 'Sabah',
	'sl' => 'Selangor',
	'sr' => 'Sarawak',
);

//
//Kose Counter
//
$config['kose_counter'] = array( 
	'kv' => array(
		1 => 'ISETAN OF JAPAN SDN BHD-KLCC',
		2 => 'ISETAN OF JAPAN SDN BHD-M.VALLEY',
		3 => 'ISETAN OF JAPAN SDN BHD-1 UTAMA',
		4 => 'ISETAN OF JAPAN SDN BHD-LOT 10',
		5 => 'AEON CO (M) BHD-(B/RAJA)',
		6 => 'AEON CO (M) BHD-BKT TINGGI',
		7 => 'AEON CO (M) BHD-BANDAR UTAMA',
		8 => 'AEON CO (M) BHD-(KEPONG)',
		9 => 'AEON CO (M) BHD-(MID VALLEY)',
		10 => 'AEON CO (M) BHD-QC MALL',
		11 => 'AEON CO (M) BHD-(T/MALURI)',
		12 => 'MJ DEPARTMENT STORES S/B-M/VALLEY',
		13 => 'PARKSON CORPORATION SDN BHD-BU2',
		14 => 'PARKSON CORPORATION SDN BHD (KLCC)',
		15 => 'PARKSON CORPORATION SDN BHD-FEST.CITY',
		16 => 'PARKSON CORPORATION SDN BHD (KLANG)',
		17 => 'PARKSON CORPORATION SDN BHD-SETIA CITY MALL',
		18 => 'PARKSON CORPORATION SDN BHD (S/P)',
		19 => 'PARKSON CORPORATION SDN BHD-PYRAMID',
		20 => 'PARKSON CORPORATION SDN BHD (SG/W)',
		21 => 'PARKSON CORPORATION SDN BHD-OUG',
		22 => 'PARKSON CORPORATION SDN BHD-PAVILION',
	),
	'pn' => array(
		24 => 'GAMA SUPERMARKET & DEPARTMENTAL STORE SDN BHD',
		25 => 'AEON CO.(M) BHD - QUEENS BAY',
		26 => 'SUNSHINE WHOLESALE MART S/B-S/S',
		27 => 'PACIFIC HYPERMKT & DEPT STORE-A/S',
		28 => 'PACIFIC HYPERMKT & DEPT STORE-PRAI SDN BHD',
		29 => 'PARKSON CORPORATION SDN BHD-1ST AVENUE',
		30 => 'PARKSON CORPORATION S/B - (GURNEY)',
		31 => 'PARKSON CORPORATION SDN BHD-SUNWAY',
		32 => 'THE STORE (MALAYSIA) S/B-CENTRAL SQ (SG. PETANI)',
	),
	'sb' => array(
		33 => 'PARKSON GRAND (KOTA KINABALU)',
		34 => 'MAYLANA (SABAH) SDN BHD',
		35 => 'MODERN COSMETIC CENTRE',
		36 => 'PARKSON ONE BORNEO',
		37 => 'MJ DEPARTMENT STORES S/B-KK SABAH',
		38 => 'KOSE BEAUTY HOUSE-TAWAU',
	),
	'sr' => array(
		33 => 'PARKSON RIA (SIBU)',
		34 => 'PARKSON THE SPRING SHOPPING MALL',
		35 => 'PARKSON CORPORATION S/B-BTNG MEGAMALL MIRI',
	),
	'pr' => array(
	 	36 => 'AEON CO (M) BHD-(IPOH)',
		37 => 'AEON CO (M) BHD-STATION 18',
		38 => 'PARKSON CORPORATION SDN BHD-IPOH (IPOH PARADE)',
		39 => 'PACIFIC HYPERMKT & DEPT STORES-TPG',
	),
	'ml' => array(
		40 => "AEON CO.(M) BHD-MELAKA 2",
		41 => "AEON CO (M) BHD-S'BAN 2",
		42 => "PACIFIC HYPERMKT & DEPT STORE S/B-B.PHT",
		43 => "PARKSON CORPORATION SDN BHD (MELAKA)",
		44 => "PARKSON CORPORATION S/B-SQUARE ONE",
		45 => "PARKSON CORPORATION SB-SEREMBAN PARADE",
		46 => "THE STORE (MALAYSIA) S/B-MUAR",
	),
	'jb' => array(                      
		47 => 'AEON CO (M) BHD - TEBRAU',
		48 => 'AEON CO.(M) BHD-BUKIT INDAH',
		49 => 'AEON CO (M) BHD-JB',
		50 => 'MJ DEPARTMENT STORES S/B-JB',
		51 => 'PARKSON CORPORATION SDN BHD (JB)',
		52 => 'PARKSON CORPORATION S/B-KLUANG',
		53 => 'THE STORE (MALAYSIA) S/B-J.BAHRU',
	),
	'kt' => array(
		54 => 'PACIFIC HYPERMKT & DEPT.STORE:KB',
		55 => 'PARKSON CORPORATION SDN BHD-KB MALL',
		56 => 'PACIFIC HYPERMKT & DEPT STORE S/B-MTKB',
	),
	'ph' => array(
		57 => 'PARKSON CORPORATION SDN BHD-EC MALL',
	),
);
$config['time_windows'] = array(
	1 => 10,
	2 => 13,
	3 => 15,
	4 => 19,
	5 => 22
);
/*** 
Items counter & state
	1 - with Kose counter
	2 - without Kose counter
***/
$config['state_counter'] = array( 
	'jh' => 1,
	'kd' => 2,
	'kt' => 2,
	'kv' => 1, 
	'ml' => 1,
	'ns' => 2, 
	'pn' => 1,	
	'pr' => 2,
	'ps' => 2,
	'sb' => 2, 
	'sr' => 1,
);

/*** 
Prize item
***/
$config['prizes'] = array( 
	1 => 'Kose Premium Lotion x 1',
	2 => 'A pair of movie ticket'
);

$config['slogan_max'] = '50'; 
$config['participantLimit'] = "3";

//
//Function that skip session authentication
//
$config['skip_auth'] = array(
	'loginUser', 'registerUser','sendCodeForgotPassword','validateCode','changeNewPassword'
);
/* End of file config_api.php */
/* Location: ./application/config/config_api.php */
