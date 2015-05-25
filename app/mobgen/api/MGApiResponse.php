<?php

/**
 * This file contains core behavior for MobgenApi Response.
 *
 * @author David Souto <david.souto@mobgen.com>
 * @link http://wiki.mobgendev.com
 */
class MGApiResponseException extends MGApiException {

}

class MGApiMissingProtocolException extends MGApiResponseException {
	
}

/**
 * This class define the base behavior for the Api response.
 * It's a bridge to separate the api protocol from the tunnel protocol
 *
 * @author David Souto <david.souto@mobgen.com>
 * @link http://wiki.mobgendev.com
 *
 *
 * */
abstract class MGApiResponse {

	private $protocol;
	public $customHeader = false;

	/**
	 * Send a response to the client
	 * @param integer $status The HTTP status code
	 * @param string $body The response
	 * @param string $content_type  JSON or other
	 * @throws  MGApiMissingProtocolException, MGApiResponseException
	 */
	public function sendResponse($status = 200, $body = '') {
		if ($this->protocol == null)
			throw new MGApiMissingProtocolException;
		$this->protocol->setCustomHeaders($this->customHeader);
		try {
			$this->protocol->sendMessage($status, $this->prepareContent($body), $this->getContentType());
		} catch (Exception $e) {
			throw new MGApiResponseException($e);
		}
	}

	public function setProtocol(IApiResponseProtocol $protocol) {
		$this->protocol = $protocol;
	}

	/**
	 * return the content type for this kind of response
	 */
	abstract public function getContentType();

	/**
	 * Prepare the response's body
	 *
	 *
	 * */
	abstract protected function prepareContent($body);
}
