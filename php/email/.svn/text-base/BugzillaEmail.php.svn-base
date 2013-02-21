<?php
class BugzillaEmail {
	
	private static $endpoint = 'bugmail@columbia.edu';
	private static $summary = 'Bug Summary';
	private $product;
	private $component;
	private $version;
	private $account;
	 
	private $message; 
	private $headers;
	
	public function __construct( $account, $product, $component, $from, $description ) {
		$this->account = $account;
		$this->product = $product;
		$this->component = $component;
		
		$this->headers .= "From: ".$account."\n";
		$this->message .= "@product = ".$product."\n";
		$this->message .= "@component = ".$component."\n";
		$this->message .= "@op_sys = All\n";
		$this->message .= "@rep_platform = All\n";
		$this->message .= "@version = unspecified\n";
		$this->message .= "@short_desc = ".self::$summary."\n"; 
		$this->message .= "\n";
		$this->message .= $description."\n\n";
		$this->message .= "Reported By: ".$from."\n";
	}
	
	public function create() {
		return mail(self::$endpoint, self::$summary, $this->message, $this->headers);
	}
}
?>