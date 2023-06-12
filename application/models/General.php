<?php
class General extends CI_Model
{
	public function __construct()
	{
			parent::__construct();
			
			
	}
	
	
	public function upload_media($input, $validextensions, $max_file_size=5, $directory='uploads'){
		if(isset($input["name"]) && $input["name"] !==''){
			$temporary = explode(".", $input["name"]);
			$file_extension = end($temporary);
			$maxSize = $max_file_size*1024*1024;
			if ($input["size"] > $maxSize){
				$res['status'] = 'error';
				$res['message'] = 'Max file size is '.$max_file_size.'MB.';
				return $res;
			}
			if (!in_array($file_extension, $validextensions)){
				$exts = implode(", ", $validextensions);
				$res['status'] = 'error';
				$res['message'] = 'Only following types are allowed '.$exts;
				return $res;
			}
			if ($input["error"] > 0) {
				$res['status'] = 'error';
				$res['message'] = $input["error"];
				return $res;
			}
			$sourcePath = $input['tmp_name']; // Storing source path of the file in a variable
			$file_name = date('ymdhis').'.'.$file_extension;
			$targetPath = $directory.'/'.$file_name; // Target path where file is to be stored
			$uploaded = move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
			
			if ($uploaded){
				$res['status'] = 'success';
				$res['file_name'] = $file_name;
				$res['directory'] = $directory;
				$res['message'] = base_url($directory.'/'.$file_name);
				return $res;
			} else {
				$res['status'] = 'error';
				$res['message'] = 'An error occured, please try again';
				return $res;
			}
		} else {
			$res['status'] = 'error';
			$res['message'] = 'File not selected';
			return $res;
		}
	}
	public function first_letter($description){
		$string = strip_tags($description);
		$string = $string[0];
		return strtoupper($string);
	}
	public function currency_convert($from, $to, $amount){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://currency-converter5.p.rapidapi.com/currency/convert?format=json&from=".$from."&to=".$to."&amount=".$amount."",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"x-rapidapi-host: currency-converter5.p.rapidapi.com",
				"x-rapidapi-key: 91899bba2fmshe56c3c4267a7ea4p1d7be2jsn60d51bc71397"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return 999991;
		} else {
			$data = json_decode($response, true);
			if ($data['status'] == 'success'){
				return $data['rates'][$to]['rate_for_amount'];
			} else {
				return 999992;
			}
		}
	}
	function timeago($time)
	{
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");
		//$time = strtotime($time);
	   $now = time();

		   $difference     = $now - $time;
		   if ($difference > 60){
			   $tense         = "ago";
			   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
				   $difference /= $lengths[$j];
			   }
			   $difference = round($difference);
			   if($difference != 1) {
				   $periods[$j].= "s";
			   }
			   return "$difference $periods[$j] ago ";
		   } else {
			   return 'online';
		   }
	}
	function timereadable($time)
	{
	   $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
	   $lengths = array("60","60","24","7","4.35","12","10");
		$time = strtotime($time);
	   $now = time();

		   $difference     = $now - $time;
		   if ($difference > 60){
			   $tense         = "ago";
			   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
				   $difference /= $lengths[$j];
			   }
			   $difference = round($difference);
			   if($difference != 1) {
				   $periods[$j].= "s";
			   }
			   return "$difference $periods[$j] ago ";
		   } else {
			   return 'Now';
		   }
	}
	public function days_to_year_months_days($days){
		$years_remaining = intval($days / 365);
		$days_remaining = $days % 365;
		
		$months_remaining = intval($days_remaining / 30);
		$days_left = $days_remaining % 30;
		$response = '';
		if ($years_remaining > 0){
			if ($years_remaining == 1){
				$year = 'Year';
			} elseif ($years_remaining > 1){
				$year = 'Years';
			}
			$response .= $years_remaining.' '.$year.' ';
		}
		if ($months_remaining > 0){
			if ($months_remaining == 1){
				$month = 'Month';
			} elseif ($months_remaining > 1){
				$month = 'Months';
			}
			$response .= $months_remaining.' '.$month.' ';
		}
		if ($days_left > 0){
			if ($days_left == 1){
				$day = 'Day';
			} elseif ($days_left > 1){
				$day = 'Days';
			}
			$response .= $days_left.' '.$day.' ';
		}
		//return $years_remaining.' Years '.$months_remaining.' Months '.$days_left;
		return $response;
	}
	function convertNumberToWord($num = false, $upper=false)
	{
		$num = str_replace(array(',', ' '), '' , trim($num));
		if(! $num) {
			return false;
		}
		$num = (int) $num;
		$words = array();
		$list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
			'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
		);
		$list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
		$list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
			'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
			'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
		);
		$num_length = strlen($num);
		$levels = (int) (($num_length + 2) / 3);
		$max_length = $levels * 3;
		$num = substr('00' . $num, -$max_length);
		$num_levels = str_split($num, 3);
		for ($i = 0; $i < count($num_levels); $i++) {
			$levels--;
			$hundreds = (int) ($num_levels[$i] / 100);
			$hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
			$tens = (int) ($num_levels[$i] % 100);
			$singles = '';
			if ( $tens < 20 ) {
				$tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
			} else {
				$tens = (int)($tens / 10);
				$tens = ' ' . $list2[$tens] . ' ';
				$singles = (int) ($num_levels[$i] % 10);
				$singles = ' ' . $list1[$singles] . ' ';
			}
			$words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
		} //end for loop
		$commas = count($words);
		if ($commas > 1) {
			$commas = $commas - 1;
		}
		if ($upper == true){
			$string = implode(' ', $words);
			return ucwords($string);
		} else {
			return implode(' ', $words);
		}
		
	}
	public function message_time($date){
		$retval = "";
		$date = strtotime($date);
		$difference = time() - $date;
		$periods = array('decade' => 315360000,
			'year' => 31536000,
			'month' => 2628000,
			'week' => 604800, 
			'day' => 86400,
			'hour' => 3600,
			'minute' => 60,
			'second' => 1);
		if ($difference < 5) { // less than 5 seconds ago, let's say "just now"
			$retval = "just now";
			return $retval;
		} elseif ($difference >=5 && $difference < 86400){
			return date('H:i', $date);
		} elseif ($difference >= 86400 && $difference < 31536000) {
			return date('M-d H:i', $date);
		} elseif ($difference >=  31536000) {
			return date('d-M-Y H:i', $date);
		}
	}
	public function readableTime($date,$granularity=0) {
		$retval = "";
		$date = strtotime($date);
		$difference = time() - $date;
		$periods = array('decade' => 315360000,
			'year' => 31536000,
			'month' => 2628000,
			'week' => 604800, 
			'day' => 86400,
			'hour' => 3600,
			'minute' => 60,
			'second' => 1);
		if ($difference < 5) { // less than 5 seconds ago, let's say "just now"
			$retval = "just now";
			return $retval;
		} else {                            
			foreach ($periods as $key => $value) {
				
				if ($difference >= $value) {
					$time = floor($difference/$value);
					$difference %= $value;
					$retval .= ($retval ? ' ' : '').$time.' ';
					$retval .= (($time > 1) ? $key.'s' : $key);
					$granularity--;
				}
				if ($granularity == '0') { break; }
			}
			return $retval. ' ago';      
		}
	}
	public function shortify_string($description, $length){
		$string = strip_tags($description);
		if (strlen($string) > $length) {
			// truncate string
			$stringCut = substr($string, 0, $length);
			// make sure it ends in a word so assassinate doesn't become ass...
			$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'... '; 
		}
		return $string;
	}
	public function array_to_string($array){
		$string = '';
			
			 $sayi=count($array);
		for ($i=0; $i<$sayi; $i++) {
			$string.=("'$array[$i]',"); //Now it is string...
		}
         return substr($string,0,-1);
	}
	public function init_pagination($page_url, $per_page, $total_records, $uri_segment){
		$config['base_url'] = $page_url;
		$config['total_rows'] = $total_records;
		$config['per_page'] = $per_page; 
		$config['uri_segment'] = $uri_segment;
		$config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		
		$config['full_tag_open'] = '<div class="text-center"><ul class="pagination">';
		$config['full_tag_close'] = '</div>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></l>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</l>';
		
		$this->pagination->initialize($config);
		$this->pagination->cur_page = $page_url;
	}
	public function init_pagination_front($page_url, $per_page, $total_records, $uri_segment){
		$config['base_url'] = $page_url;
		$config['total_rows'] = $total_records;
		$config['per_page'] = $per_page; 
		$config['uri_segment'] = $uri_segment;
		$config['num_links'] = 2;
		$config['use_page_numbers'] = TRUE;
		
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		
		$config['full_tag_open'] = '<div class="c-pagination"><ul>';
		$config['full_tag_close'] = '</div>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="m-active"><a>';
		$config['cur_tag_close'] = '</a></l>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</l>';
		
		$this->pagination->initialize($config);
		$this->pagination->cur_page = $page_url;
	}
	public function get_pagination_data($table, $per_page, $page, $order_by, $order){
		$result= $this->db->query("SELECT * FROM $table ORDER BY $order_by $order LIMIT {$page}, {$per_page}")->result_array();
		return $result;
	}
	public function get_pagination_data_where($table, $per_page, $page, $where, $value, $order_by, $order){
		$result= $this->db->query("
		SELECT * FROM $table 
		WHERE 
		$where = '$value' 
		ORDER BY 
		$order_by $order 
		LIMIT 
		{$page}, {$per_page}")->result_array();
		return $result;
	}
	public function post_api($url, $array){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close ($ch);
		return $server_output;
	}
	function addParagraphsNew($text){
		// local variables
		$returntext = '';       // modified string to return back to caller
		$sections   = array();  // array of text sections returned by preg_split()
		$pattern1   = '%        # match: <tag attrib="xyz">contents</tag>
		 ^                       # tag must start on the beginning of a line
		 (                       # capture whole thing in group 1
		   <                     # opening tag starts with left angle bracket
		   (\w++)                # capture tag name into group 2
		   [^>]*+                # allow any attributes in opening tag
		   >                     # opening tag ends with right angle bracket
		   .*?                   # lazily grab everything up to closing tag
		   </\2>                 # closing tag for one we just opened
		 )                       # end capture group 1
		 $                       # tag must end on the end of a line
		 %smx';                  // s-dot matches newline, m-multiline, x-free-spacing
		  
		$pattern2   = '%        # match: \n--untagged paragraph--\n
		 (?:                     # non-capture group for first alternation. Match either...
		   \s*\n\s*+             # a newline and all surrounding whitespace (and discard)
		 |                       # or...
		   ^                     # the beginning of the string
		 )                       # end of first alternation group
		 (.+?)                   # capture all text between newlines (or string ends)
		 (?:\s+$)?               # clear out any whitespace at end of string
		 (?=                     # end of paragraph is position followed by either...
		   \s*\n\s*              # a newline with optional surrounding whitespace
		 |                       # or...
		   $                     # the end of the string
		 )                       # end of second alternation group
		 %x';                    // x-free-spacing
		  
		// first split text into tagged portions and untagged portions
		// Note that the array returned by preg_split with PREG_SPLIT_DELIM_CAPTURE flag will get one
		// extra member for each set of capturing parentheses. In this case, we have two sets; 1 - to
		// capture the whole HTML tagged section, and 2 - to capture the tag name (which is needed to
		// match the closing tag).
		$sections = preg_split($pattern1, $text, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
		  
		// now put it back together proccessing only the untagged sections
		for ($i = 0; $i < count($sections); $i++) {
			 if (preg_match($pattern1, $sections[$i]))
			 { // this is a tagged paragraph, don't modify it, just add it (and increment array ptr)
				 $returntext .= "\n" . $sections[$i] . "\n";
				 $i++; // need to skip over the extra array element for capture group 2
			 } else
			 { // this is an untagged section. Add paragraph tags around bare paragraphs
				 $returntext .= preg_replace($pattern2, "\n<p>$1</p>\n", $sections[$i]);
			 }
		}
		$returntext = preg_replace('/^\s+/', '', $returntext); // clean leading whitespace
		$returntext = preg_replace('/\s+$/', '', $returntext); // clean trailing whitespace
		return $returntext;
	}
	
	public function icon_by_type($extension){
		if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png'){
			return '<i class="fa fa-file-image-o" aria-hidden="true"></i>';
		} elseif ($extension == 'docx'){
			return '<i class="fa fa-file-word-o" aria-hidden="true"></i>';
		} elseif ($extension == 'xlsx'){
			return '<i class="fa fa-file-excel-o" aria-hidden="true"></i>';
		} elseif ($extension == 'ppt'){
			return '<i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>';
		} elseif ($extension == 'pdf'){
			return '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>';
		} elseif ($extension == 'mp3'){
			return '<i class="fa fa-file-audio-o" aria-hidden="true"></i>';
		} elseif ($extension == 'rar'){
			return '<i class="fa fa-file-archive-o" aria-hidden="true"></i>';
		} elseif ($extension == 'zip'){
			return '<i class="fa fa-file-archive-o" aria-hidden="true"></i>';
		} elseif ($extension == 'mp4' || $extension == 'avi' || $extension == 'mov'){
			return '<i class="fa fa-file-video-o" aria-hidden="true"></i>';
		}
	}
	public function is_numeric_array($numbers_array){
		if (count($numbers_array)>0){
			foreach ($numbers_array as $a => $b) {
				if (!is_numeric($b)) {
					return false;
				}
			}
			return true;
		} else {
			return false;
		}
	}
	public function time_ago($date,$granularity=2) {
			$retval = "";
			$date = strtotime($date);
			if ($date + 86400 >= time()){
				$difference = time() - $date;
				$periods = array('decade' => 315360000,
					'year' => 31536000,
					'month' => 2628000,
					'week' => 604800, 
					'day' => 86400,
					'hour' => 3600,
					'minute' => 60,
					'second' => 1);
				if ($difference < 5) { // less than 5 seconds ago, let's say "just now"
					$retval = "just now";
					return $retval;
				} else {                            
					foreach ($periods as $key => $value) {
						
						if ($difference >= $value) {
							$time = floor($difference/$value);
							$difference %= $value;
							$retval .= ($retval ? ' ' : '').$time.' ';
							$retval .= (($time > 1) ? $key.'s' : $key);
							$granularity--;
						}
						if ($granularity == '0') { break; }
					}
					return $retval. ' Ago';      
				}
			} elseif ($date + 172800 >= time()){
				return 'Yesterday '.date('h:i A', $date);
			} else {
				return date('F jS, Y h:i A', $date);
			}
			
		}
	
	public static function slugify($text)
	{
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  //$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);

	  if (empty($text)) {
		return 'n-a';
	  }

	  return $text;
	}
	public function create_salt($length = 15, $letters = 'QUERTYUIOPASDFGHJKLZXCVBNM')
	{
		$s = '';
		$lettersLength = strlen($letters)-1;
		for($i = 0 ; $i < $length ; $i++){
			$s .= $letters[rand(0,$lettersLength)];	
		}			
		return $s;
	}
	
	public function random_string($length = 10, $letters = 'q1wer23ty45uiop67lkjh89gfdsam0nbvcxz'){
		$s = '';
		$lettersLength = strlen($letters)-1;
		for($i = 0 ; $i < $length ; $i++){
			$s .= $letters[rand(0,$lettersLength)];	
		}			
		return $s;
	}
	public function five_digit_key($length = 5, $letters = '1234567890'){
		$s = '';
		$lettersLength = strlen($letters)-1;
		for($i = 0 ; $i < $length ; $i++){
			$s .= $letters[rand(0,$lettersLength)];	
		}			
		return $s;
	}
	
	public function generate_ref_id($length = 10, $letters = 'Q1WER23TY45UIOP67lKJH89GFDSAM0NBVCXZ'){
		$s = $this->random_string(5).'-'.$this->random_string(4).'-'.$this->random_string(4);
		return strtoupper($s);
	}	
	
	/************** Encryption and Decryption *******************/
	
	public function password($password,$user_salt) {
		return $this->hashme($password, null, true,$user_salt);
	}
	
	public function hashme($string, $type = null, $salt = false, $user_salt) {
		
		if ($salt){				
			$string = $user_salt.$string;
		}
		$type = strtolower($type);
		if ($type == 'sha1' || $type == null) {
			if (function_exists('sha1')) {
				$return = sha1($string);
				return $return;
				} else {
				$type = 'sha256';
			}
		}
		if ($type == 'sha256') {
			if (function_exists('mhash')) {
				$return = bin2hex(mhash(MHASH_SHA256, $string));
				return $return;
				} else {
				$type = 'md5';
			}
		}
		
		if ($type == 'md5') {
			$return = md5($string);
			return $return;
		}
	}
	
	public function read(){
		$name = 'c336y7/3944/654/y4*y4u62573544352q54j31h43545435q35ch4';
		return $name;
	}
	
	/************** Encryption and Decryption *******************/
	
	public function get_commission_var($optionname)
	{

		$this->db->select('option_value');
		$this->db->from('commission_settings');
		$this->db->where('option_name',$optionname);

		$data = $this->db->get()->result_array();

		if(count($data) > 0){
			return $data[0]['option_value'];
		}else{
			return '';
		}
	}
	public function get_social_media($name, $icon_class='', $link_class=''){
		$link = '';
		$value = $this->get_system_var($name);
		if ($value !== ''){
			$link = '<a href="'.$value.'" class="'.$link_class.'"><i class="'.$icon_class.'"></i></a>';
		}
		return $link;
	}
	public function get_system_var($optionname)
	{

		$this->db->select('option_value');
		$this->db->from('options');
		$this->db->where('option_name',$optionname);

		$data = $this->db->get()->result_array();

		if(count($data) > 0){
			return $data[0]['option_value'];
		}else{
			return '';
		}
	}
	
	public function delete_tbl_data($tbl_name, $where, $value){
		$this->db->where($where,$value);
		$this->db->delete($tbl_name);
		if ($this->db->affected_rows()){
			return true;
		} else {
			return false;
		}
		
	}
	public function delete_tbl_data_2($tbl_name, $where, $value, $where1, $value1){
		$this->db->where($where,$value);
		$this->db->where($where1,$value1);
		$this->db->delete($tbl_name);
		if ($this->db->affected_rows()){
			return true;
		} else {
			return false;
		}
		
	}
	public function updated_at_date_text_format(){
		return date("F j, Y g:i a");
	}
	
	public function todate_text_format(){
		return date("F j, Y");
	}
	
	public function get_all_tbl_data($tbl_name, $fields){
		$this->db->select($fields);
		$this->db->from($tbl_name);
		return $this->db->get()->result_array();
	}
	public function get_all_data_by_order($tbl_name, $fields, $order_by, $order){
		$this->db->select($fields);
		$this->db->from($tbl_name);
		$this->db->order_by($order_by, $order);
		return $this->db->get()->result_array();
	}
	public function readable_date($datetime){
		$old_date_timestamp = strtotime($datetime);
		$new_date = date('F j,Y', $old_date_timestamp);
		return $new_date;
	}
	public function get_all_tbl_data_with_pagination($tbl_name, $fields, $per_page, $page){
		$this->db->select($fields);
		$this->db->from($tbl_name);
		$this->db->where('userid', $this->session->userdata('userid'));
		$this->db->order_by("id", "DESC");
		$this->db->limit($per_page, $page);
		return $this->db->get()->result_array();
	}
			
	
	public function get_tbl_field($tbl_name, $field_name, $where, $value){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->order_by("id", 'DESC');
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_no_order($tbl_name, $field_name, $where, $value){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_like($tbl_name, $field_name, $where, $value){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->like($where,$value);
		$this->db->order_by("id", 'DESC');
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_like2($tbl_name, $field_name, $where, $value, $where1, $value1){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->like($where,$value);
		$this->db->or_like($where1,$value1);
		$this->db->order_by("id", 'DESC');
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_like3($tbl_name, $field_name, $where, $value, $where1, $value1, $where2, $value2){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->like($where,$value);
		$this->db->or_like($where1,$value1);
		$this->db->or_like($where2,$value2);
		$this->db->order_by("id", 'DESC');
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_like4($tbl_name, $field_name, $where, $value, $where1, $value1, $where2, $value2, $where3, $value3){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->like($where,$value);
		$this->db->or_like($where1,$value1);
		$this->db->or_like($where2,$value2);
		$this->db->or_like($where3,$value3);
		$this->db->order_by("id", 'DESC');
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_order($tbl_name, $field_name, $where, $value, $order){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->order_by("id", $order);
		
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_by_order($tbl_name, $field_name, $where, $value, $order_by, $order){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->order_by($order_by, $order);
		
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_data_order_limit($tbl_name, $field_name, $order, $limit){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->order_by("id", $order);
		$this->db->limit($limit);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_all_field_order_limit($tbl_name, $field_name, $order, $limit){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->order_by("id", $order);
		$this->db->limit($limit);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_order_limit($tbl_name, $field_name, $where, $value, $order, $limit){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->order_by("id", $order);
		$this->db->limit($limit);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_2_order_limit($tbl_name, $field_name, $where, $value, $where1, $value1, $order, $limit){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->where($where1,$value1);
		$this->db->order_by("id", $order);
		$this->db->limit($limit);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_3_order_limit($tbl_name, $field_name, $where, $value, $where1, $value1, $where2, $value2, $order, $limit){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->where($where1,$value1);
		$this->db->where($where2,$value2);
		$this->db->order_by("id", $order);
		$this->db->limit($limit);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_4_order_limit($tbl_name, $field_name, $where, $value, $where1, $value1, $where2, $value2, $where3, $value4, $order, $limit){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->where($where1,$value1);
		$this->db->where($where2,$value2);
		$this->db->where($where3,$value4);
		$this->db->order_by("id", $order);
		$this->db->limit($limit);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	
	public function get_data_by_order($tbl_name, $field_name, $order){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->order_by("id", $order);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	
	
	
	public function get_tbl_field_where2($tbl_name, $field_name, $where, $value, $where1, $value1){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->where($where1,$value1);
		$this->db->order_by("id", "DESC");
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	
	public function get_tbl_field_where2_limit($tbl_name, $field_name, $where, $value, $where1, $value1, $limit){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->where($where1,$value1);
		$this->db->order_by("id", "DESC");
		$this->db->limit($limit);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_where3($tbl_name, $field_name, $where, $value, $where1, $value1, $where2, $value2){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->where($where1,$value1);
		$this->db->where($where2,$value2);
		$this->db->order_by("id", "DESC");
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	public function get_tbl_field_where3_limit($tbl_name, $field_name, $where, $value, $where1, $value1, $where2, $value2, $limit){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->where($where1,$value1);
		$this->db->where($where2,$value2);
		$this->db->order_by("id", "DESC");
		$this->db->limit($limit);
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	
	
	public function insert_data($tbl_name, $data_arr)
	{
		return $this->db->insert($tbl_name, $data_arr);
	}
	
	

	public function insert_data_for_id($tbl_name, $data_arr)
	{
		$is_insert = $this->db->insert($tbl_name, $data_arr);
		if($is_insert){
			return $this->db->insert_id();
		}else{
			return '';
		}
	}
	
	public function update_data($tbl_name, $field, $value, $data_arr)
	{
		$this->db->where($field, $value);
		return $this->db->update($tbl_name, $data_arr); 
	}

	public function update_data2($tbl_name, $field, $value, $field2, $value2, $data_arr)
	{
		$this->db->where($field2, $value2);
		$this->db->where($field, $value);
		return $this->db->update($tbl_name, $data_arr); 
	}
	
	function cvf_convert_object_to_array($data) {

    if (is_object($data)) {
        $data = get_object_vars($data);
    }

    if (is_array($data)) {
        return array_map(__FUNCTION__, $data);
    }
    else {
        return $data;
    }
}
	

	
	public function detect_url_protocol(){
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") { 
			return 'https://';
		} else { 
			return 'https://';
		}
	}
	
	public function dateRange( $first, $last, $step = '+1 day', $format = 'd M' ) {
	
		$dates = array();
		$current = strtotime( $first );
		$last = strtotime( $last );
	
		while( $current <= $last ) {
	
			$dates[] = date( $format, $current );
			$current = strtotime( $step, $current );
		}
	
		return $dates;
	}
	
	public function get_random_data($tblname){
		
		$this->db->order_by('id', 'RANDOM');
		//$this->db->order_by('rand()');
		$this->db->limit(1);
		$query = $this->db->get($tblname);
		return $query->result_array();
		
	}
	
	public function get_tbl_field_2_order($tbl_name, $field_name, $where, $value, $where1, $value1, $order_by, $order){
		$this->db->select($field_name);
		$this->db->from($tbl_name);
		$this->db->where($where,$value);
		$this->db->where($where1,$value1);
		$this->db->order_by($order_by, $order);
		
		$adminid_exists = $this->db->get()->result_array();
		
		if(count($adminid_exists) > 0){
			return $adminid_exists;
		}else{
			return array();
		}
	}
	
}
