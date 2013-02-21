<?php

class StderrLogger extends Logger {
	
	final public function __construct( $mask ) {
		$this->mask = $mask; 
	}
	
	final public function writeMessage( $msg ) {
		print "Writing to stderr: {$msg}\n";
	}
}
?>