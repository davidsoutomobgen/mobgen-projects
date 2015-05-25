<?php

/**
 * This class define the protocol used to respond to a client's request
 *
 *   @author David Souto <david.souto@mobgen.com>
 * @link http://wiki.mobgendev.com
 * */
class MGApiResponseProtocolHttp11 implements IApiResponseProtocol {

	public $customHeader = false;

	/**
	 * send a massage using a specific protocol (HTTP1.0, HTTP1.1, custom protocol and so on)
	 */
	public function sendMessage($status = 200, $body = '', $content_type = 'application/text') {
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
		header($status_header);

		header('Content-type: ' . $content_type);
		if ($this->customHeader)
			header($this->customHeader);

		echo $body;
	}

	/**
	 * Return status message for code
	 * @param integer $status The HTTP status code
	 * @return string  The text of the HTTP status code
	 */
	private function _getStatusCodeMessage($status) {
		switch ($status) {
			case 100: $text = 'Continue';
				break;
			case 101: $text = 'Switching Protocols';
				break;
			case 200: $text = 'OK';
				break;
			case 201: $text = 'Created';
				break;
			case 202: $text = 'Accepted';
				break;
			case 203: $text = 'Non-Authoritative Information';
				break;
			case 204: $text = 'No Content';
				break;
			case 205: $text = 'Reset Content';
				break;
			case 206: $text = 'Partial Content';
				break;
			case 300: $text = 'Multiple Choices';
				break;
			case 301: $text = 'Moved Permanently';
				break;
			case 302: $text = 'Moved Temporarily';
				break;
			case 303: $text = 'See Other';
				break;
			case 304: $text = 'Not Modified';
				break;
			case 305: $text = 'Use Proxy';
				break;
			case 400: $text = 'Bad Request';
				break;
			case 401: $text = 'Unauthorized';
				break;
			case 402: $text = 'Payment Required';
				break;
			case 403: $text = 'Forbidden';
				break;
			case 404: $text = 'Not Found';
				break;
			case 405: $text = 'Method Not Allowed';
				break;
			case 406: $text = 'Not Acceptable';
				break;
			case 407: $text = 'Proxy Authentication Required';
				break;
			case 408: $text = 'Request Time-out';
				break;
			case 409: $text = 'Conflict';
				break;
			case 410: $text = 'Gone';
				break;
			case 411: $text = 'Length Required';
				break;
			case 412: $text = 'Precondition Failed';
				break;
			case 413: $text = 'Request Entity Too Large';
				break;
			case 414: $text = 'Request-URI Too Large';
				break;
			case 415: $text = 'Unsupported Media Type';
				break;
			case 500: $text = 'Internal Server Error';
				break;
			case 501: $text = 'Not Implemented';
				break;
			case 502: $text = 'Bad Gateway';
				break;
			case 503: $text = 'Service Unavailable';
				break;
			case 504: $text = 'Gateway Time-out';
				break;
			case 505: $text = 'HTTP Version not supported';
				break;
			default:
				exit('Unknown http status code "' . htmlentities($code) . '"');
				break;
		}

		return $text;
	}

	public function setCustomHeaders($headers) {

	}

}