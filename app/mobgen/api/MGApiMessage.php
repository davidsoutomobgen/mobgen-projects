<?php

/**
 *
 * Message for the API
 *
 * @author David Souto <david.souto@mobgen.com>
 */
class MGApiMessage {

	public $message;
	public $details;

	/**
	 * Defines a specific errorHandler for the api context
	 */
	public function __construct($message, Array $details) {

		$this->message = $message;
		$this->details = $details;
	}

}
