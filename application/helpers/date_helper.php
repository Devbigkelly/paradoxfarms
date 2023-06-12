<?php
if(!function_exists('validateDate')){
	function validateDate($date, $format = 'd-m-Y')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}
}
if(!function_exists('dbdateconvert')){
	function dbdateconvert($_date){
		$date=str_ireplace('/','-',$_date);
		return date('Y-m-d',strtotime($date));
		
	}
}
if(!function_exists('dbdate_convert')){
	function dbdate_convert($date, $format = 'd-m-Y')
	{
		$d = DateTime::createFromFormat($format, $date);
		if($d && $d->format($format) === $date){
			return $d->format('Y-m-d');
		} else {
			return '';
		}
	}
}
if(!function_exists('validateDateTime')){
	function validateDateTime($date, $format = 'd-m-Y H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}
}
if(!function_exists('dbdatetimeconvert')){
	function dbdatetimeconvert($date){
		$date=str_ireplace('/','-',$date);
		return date('Y-m-d H:i:s',strtotime($date));
	}
}
if(!function_exists('frontdateconvert')){
	function frontdateconvert($date,$format='Y-m-d'){
		$d = DateTime::createFromFormat($format, $date);
		return $d->format('d-m-Y');
		//return date('d-m-Y',strtotime($date));
	}
}
if(!function_exists('frontdatetimeconvert')){
	function frontdatetimeconvert($date){
		return date('d-m-Y H:i:s',strtotime($date));
	}
}
if(!function_exists('date_valid')){
	function date_valid($date)
  {
	$date=str_ireplace("/","-",$date);
    $parts = explode("-", $date);
    if (count($parts) == 3) {      
      if (checkdate($parts[1], $parts[0], $parts[2]))
      {
        return TRUE;
      }
    }
    return false;
  }

}
if(!function_exists('calculate')){
function calculate($date){
	if($date!=''){
 $today = date("Y-m-d");
 $diff = date_diff(date_create($date), date_create($today));
return $diff->format('%y');
	}
}
}
if(!function_exists('mydatedif')){
function mydatedif($date1,$date2){
	$d1 = new DateTime($date1);
$d2 = new DateTime($date2);

$diff = $d2->diff($d1);

return $diff;// $diff->y;
}
}
if(!function_exists('humanreadabledate')){
function humanreadabledate($Joiningdate,$date2=''){
		$date1 = date("Y-m-d H:i:s",strtotime($Joiningdate));
		if($date2==''){$date2 = date("Y-m-d H:i:s");}
		 $diff = abs(strtotime($date2) - strtotime($date1));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$totaldays=	floor($diff / (60 * 60 * 24))	;
		$hour=	floor($diff / (60 * 60))	;
		$minute=	floor(($diff- ($hour*60 * 60)) / (60))	;
	
		return array('years'=>@$years,'months'=>@$months,'days'=>@$days,'totaldays'=>@$totaldays,'hour'=>@$hour,'minute'=>@$minute);
		
	}
}
if(!function_exists('convert_number_to_words')){
function convert_number_to_words($number) {
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
}
?>