<?php
require_once('enum.php');


function executution_environment() {
	return defined('STDIN') ? 'cli' : 'cgi';
}

function __autoload( $resource ) {
	if( $class = explode('\\', $resource) )
		$class = array_pop($class);
		
	include_once("$class.php");

	if ( !class_exists($resource, false) && !interface_exists($resource, false) ) {
        trigger_error("Unable to load class: $class", E_USER_WARNING);
    }
}

function r( array $array ) {
	print '<pre>'.print_r($array, true).'</pre>';
}

function v( $object ) {
	var_dump($object);
}

function println( $string ) {
	print $string."\n";
}

function a( $object ) {
	if( is_scalar($object) ) {
		return array($object);
	} else
	if( is_object($object) ) {
		return object_to_array($object);
	} else
	if( is_array($object) ) {
		return $object;
	} else {
		return array();
	}
}

function t($conditional, $value) {
	return $conditional ? $value : null;
}

function f($conditional, $value) {
	return $conditional ? null : $value;
}

function error_handler($errno, $errstr, $errfile, $errline ) {
//	print "Error $errno: ".$errstr."\n";
//	print "File: ".$errfile."\n";
//	print "Line: ".$errline."\n";
//	throw new WebicsErrorException($errstr, 0, $errno, $errfile, $errline);
}

function exception_handler(Exception $exception) {
	print '<pre>';
	print "Exception: ".$exception->getMessage()."\n";
	print "File: ".$exception->getFile()."\n";
	print "Line: ".$exception->getLine()."\n";
	print "Trace:".print_r($exception->getTrace(), true)."\n";
	print '</pre>';
}

function assert_handler($file, $line, $message) {
    throw new FailedAssertionException($message);
}

function debug( $message, $level = 3 ) {
	if( $level == 0 ) print "<br /><b>BENCH:</b> $message <br /><br />\n";
	else if( $level <= DEBUG ) print "<b>DEBUG:</b> $message <br />\n";
}

function array_to_object( $array ) {
    if( empty($array) ) return false;
    $data = new Std();
    foreach( $array as $akey => $aval ) {
    	$data->{$akey} = is_array($aval) ? array_to_object($aval) : $aval;
    }
    return $data;
}

function object_to_array( $object ) {
	if( empty($object) ) return false;
	$data = array();
	foreach( $object as $akey => $aval ) {
		$data[$akey] = is_object($aval) ? object_to_array($aval) : $aval;
	}
	return $data;
}

function get_types( array $values ) {
	$type = '';
	foreach( $values as $value ) {
		if( is_integer($value) || $value instanceOf Integer )
			$type .= 'i';
		elseif( is_double($value) || $value instanceOf Float )
			$type .= 'd';
		elseif( is_string($value) || $value instanceOf String )
			$type .= 's';
		else
			$type .= 'i';
	}
	return $type;
}

function parse_key_value_pair( $pair ) {
	return array_reverse(preg_split('/[=|==|=>]/', $pair));
}

function is_associative( $array ) {
    if ( empty($array) ) return false;
    for ( $iterator = count($array) - 1; $iterator; $iterator-- ) {
   		if ( ! array_key_exists($iterator, $array) ) { return true; }
    }
    return ! array_key_exists(0, $array);
}

function array_prefix_values( $prefix, $array ) {
	foreach($array as $key=>$value) {
		$array[$key] = $prefix.$value;
	}
	return $array;
}

function array_postfix_values( $postfix, $array) {
	foreach($array as $key=>$value) {
		$array[$key] = $value.$postfix;
	}
	return $array;	
}

function array_prefix_keys( $prefix, $array ) {
	foreach($array as $key=>$value) {
		$array[$prefix.$key] = $value;
		unset($array[$key]);
	}
	return $array;
}

function array_unprefix_keys( $prefix, $array ) {
	foreach($array as $key=>$value) {
		$array[str_replace($prefix, '', $key)] = $value;
		unset($array[$key]);
	}
	return $array;
}

function reference_to_copy( $var ) {
	return unserialize(serialize($var));
}

function array_key_search( $needle, $haystack ) {
	return (bool) (in_array(strtolower($needle), array_map('strtolower', array_keys($haystack))));
}

function array_value( $key, $array ) {
	$array = array_change_key_case($array, CASE_LOWER);
	return in_array(strtolower($key), array_keys($array)) ? $array[strtolower($key)] : null;
}

function array_extract( $array, $keys ) {
	$extract = array();
	foreach( $keys as $key ) {
		$extract[$key] = $array[$key];
	}
	return $extract;
}

function get_caller_method( $level = 1 ) {
    $traces = array_shift(debug_backtrace()); 
    if (isset($traces[$level])) { 
        return $traces[$level]['function']; 
    } 

    return null; 
}

function get_caller_class( $level = 1 ) {
    $traces = debug_backtrace(); 
	array_shift($traces);
    if( is_array($level) ) {
		foreach(  $traces as $trace ) {
			if( !in_array($trace['class'], $level) )
				return $trace['class'];
		}
    }
    if (isset($traces[$level])) { 
        return $traces[$level]['class']; 
    } 

    return null; 
}

function restrict_method_access( $allowed_classes ) {
	if( !in_array(get_caller_class(2), a($allowed_classes)) )
		throw new UnknownMethodException(get_caller_method());
}

function createRandomPassword() {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }

    return $pass;

}

function call( $func, $args ) {
	switch(count($args)) {
		case 0: return $func(); break;
		case 1: return $func($args[0]); break;
		case 2: return $func($args[0],$args[1]); break;
		case 3: return $func($args[0],$args[1],$args[2]); break;
		case 4: return $func($args[0],$args[1],$args[2],$args[3]); break;
		case 5: return $func($args[0],$args[1],$args[2],$args[3],$args[4],$args[5]); break;
		case 6: return $func($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6]); break;
		case 7: return $func($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7]); break;
		case 8: return $func($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8]); break;
		case 9: return $func($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9]); break;
	}
}

function call_static( $class, $method, $args ) {
	switch(count($args)) {
		case 0: $class::$method(); break;
		case 1: $class::$method($args[0]); break;
		case 2: $class::$method($args[0],$args[1]); break;
		case 3: $class::$method($args[0],$args[1],$args[2]); break;
		case 4: $class::$method($args[0],$args[1],$args[2],$args[3]); break;
		case 5: $class::$method($args[0],$args[1],$args[2],$args[3],$args[4],$args[5]); break;
		case 6: $class::$method($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6]); break;
		case 7: $class::$method($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7]); break;
		case 8: $class::$method($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8]); break;
		case 9: $class::$method($args[0],$args[1],$args[2],$args[3],$args[4],$args[5],$args[6],$args[7],$args[8],$args[9]); break;
	}
}

function runExternal( $cmd, &$code ) {

   $descriptorspec = array(
       0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
       1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
       2 => array("pipe", "w") // stderr is a file to write to
   );

   $pipes= array();
   $process = proc_open($cmd, $descriptorspec, $pipes);

   $output= "";

   if (!is_resource($process)) return false;

   #close child's input imidiately
   fclose($pipes[0]);

   stream_set_blocking($pipes[1],false);
   stream_set_blocking($pipes[2],false);

   $todo= array($pipes[1],$pipes[2]);

   while( true ) {
       $read= array();
       if( !feof($pipes[1]) ) $read[]= $pipes[1];
       if( !feof($pipes[2]) ) $read[]= $pipes[2];

       if (!$read) break;

       $ready= stream_select($read, $write=NULL, $ex= NULL, 2);

       if ($ready === false) {
           break; #should never happen - something died
       }

       foreach ($read as $r) {
           $s= fread($r,1024);
           $output.= $s;
       }
   }

   fclose($pipes[1]);
   fclose($pipes[2]);

   $code= proc_close($process);

   return $output;
}
?>