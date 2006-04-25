<?

define('undefined','_amodules3_undefined_value');

if(!function_exists('lowlevel_error')){
function lowlevel_error($error,$lev=null){
    /*
     * This function will be called for low level fatal errors
     */
    echo "<font color=red>Low level error:</font> $error<br>";
    exit;
}
};if(!function_exists('error_handler')){
function error_handler($errno, $errstr, $errfile, $errline){
    $errfile=dirname($errfile).'/<b>'.basename($errfile).'</b>';
    $str="<font style='font-family: verdana;  font-size:10px'><font color=blue>$errfile:$errline</font> <font color=red>[$errno] <b>$errstr</b></font></font>";
    switch ($errno) {
        case 2:
            if(strpos($errstr,'mysql_connect')!==false)break;
        case 8:
            if(substr($errstr,0,16)=='Undefined offset')break;
            if(substr($errstr,0,15)=='Undefined index')break;
        case 2048:
            if(substr($errstr,0,15)=='var: Deprecated')break;
            if(substr($errstr,0,17)=='Non-static method')break;
        default:
            echo "$str<br />\n";
            break;
    }
}
/*
};if(!function_exists('htmlize_exception')){
function htmlize_exception($e,$msg){
    //$e->HTMLize();
    echo $e->getMessage()."<br>\n";
}
*/
};if(!function_exists('safe_array_merge')){
    // array_merge gives us an error when one of arguments is null. This function
    // acts the same as array_merge, but without warnings
    function safe_array_merge($a,$b=null){
        if(is_null($a)){
            $a=$b;
            $b=null;
        }
        if(is_null($b))return $a;
        return array_merge($a,$b);
    }
};if(!function_exists('hash_filter')){
    // array_merge gives us an error when one of arguments is null. This function
    // acts the same as array_merge, but without warnings
    function hash_filter($hash,$allowed_keys){
        // This function will filter only keys/values from hash which are
        // in allowed_keys as well.
        $result = array();
        foreach($allowed_keys as $key=>$newkey){
            if(is_int($key))$key=$newkey;
            if(isset($hash[$key])){
                $result[$newkey]=$hash[$key];
            }
        }
        return $result;
    }
};if(!function_exists('caller_lookup')){
    // sometimes i wonder, who called some specific function. Now you can find out
    // caller_lookup relies on backtrack info to pull out into about caller class
    function caller_lookup($shift=0,$file=false){
        // This function will filter only keys/values from hash which are
        // in allowed_keys as well.
        $bt=debug_backtrace();
        $shift+=3;
        @$r=(
                ($file?$bt[$shift]['file'].":".$bt[$shift]['line'].":":"").
                $bt[$shift]['class'].
                $bt[$shift]['type'].
                $bt[$shift]['function']);
        return $r;
    }
};if(!function_exists('__autoload')){
    function __autoload($class){

        $file = str_replace('_',DIRECTORY_SEPARATOR,$class).'.php';
        if(!include_once($file)){
            lowlevel_error("Unable to load $file for $class");
        }
        if(class_exists($class))return;

        lowlevel_error("Class $class is not defined in $file");
    }
};if(!function_exists('format_time')){
	function format_time($s, $exclude_seconds = false){
		$m=floor($s/60);$s=$s%60;
		$h=floor($m/60);$m=$m%60;
		//if(!$h)return sprintf("%02d:%02d",$m,$s);
		if($exclude_seconds)return sprintf("%d:%02d",$h,$m);
		return sprintf("%02d:%02d:%02d",$h,$m,$s);
	}
}