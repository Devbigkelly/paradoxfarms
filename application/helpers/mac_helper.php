<?php if(!function_exists('mac_address')){
function mac_address(){
	return 'B8-2A-72-B5-01-13';
	$return_array = array();
switch ( strtolower(PHP_OS) ){
case "linux":
$return_array =forLinux();
break;
case "solaris":
break;
case "unix":
break;
case "aix":
break;
default:
$return_array =forWindows();
break;
}
$temp_array = array();

foreach ( $return_array as $value ){

if (preg_match("/[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f][:-]"."[0-9a-f][0-9a-f]/i",$value,
$temp_array ) ){
$mac_addr = $temp_array[0];
break;
}

}
unset($temp_array);
	return($mac_addr);
return $mac_addr=='' ? 'B8-2A-72-B5-01-13' : $mac_addr='B8-2A-72-B5-01-13';
}
}
if(!function_exists('forWindows')){
function forWindows(){
@exec("ipconfig /all", $return_array);
if ( $return_array )
return $return_array;
else{
$ipconfig = $_SERVER["WINDIR"]."\system32\ipconfig.exe";
if ( is_file($ipconfig) )
@exec($ipconfig." /all", $return_array);
else
@exec($_SERVER["WINDIR"]."\system\ipconfig.exe /all", $return_array);
return $return_array;
}
}
}
if(!function_exists('forLinux')){
function forLinux(){
@exec("ifconfig -a", $return_array);
return $return_array;
}
}
if(!function_exists('getMacLinux')){
function getMacLinux() {
  exec('netstat -ie', $result);
   if(is_array($result)) {
    $iface = array();
    foreach($result as $key => $line) {
      if($key > 0) {
        $tmp = str_replace(" ", "", substr($line, 0, 10));
        if($tmp <> "") {
          $macpos = strpos($line, "HWaddr");
          if($macpos !== false) {
            $iface[] = array('iface' => $tmp, 'mac' => strtolower(substr($line, $macpos+7, 17)));
          }
        }
      }
    }
    return $iface[0]['mac'];
  } else {
    return "notfound";
  }
}
}
if(!function_exists('deleteDirectory')){
function deleteDirectory($dir) { 
        if (!file_exists($dir)) { return true; }
        if (!is_dir($dir) || is_link($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) { 
            if ($item == '.' || $item == '..') { continue; }
            if (!deleteDirectory($dir . "/" . $item, false)) { 
                chmod($dir . "/" . $item, 0777); 
                if (!deleteDirectory($dir . "/" . $item, false)) return false; 
            }; 
        } 
        return rmdir($dir); 
    }
}