<?php

abstract class Logger extends Object {
	const ERR = 3;
    const NOTICE = 5;
    const DEBUG = 7;

    protected $mask;
	private $next;

	public function setNext( Logger $l ) {
		$this->next = $l;
        return $this;
    }

    public function message( $msg, $priority ) {

	    if ($priority <= $this->mask) {
	    	$this->writeMessage( $msg );
	    }
	    if (false == is_null($this->next)) {
	   		$this->next->message($msg, $priority);
	    }
    }

    abstract public function writeMessage( $msg );
}
?>