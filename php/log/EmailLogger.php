<?php

class EmailLogger extends Logger {
	
	final public function __construct( $mask ) {
		$this->mask = $mask; 
	}
	
	final public function writeMessage( $msg ) {
		print "Sending via email: {$msg}\n";
	}
}
?>