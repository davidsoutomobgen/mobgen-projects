<?php

class ApiResponse
{
	private $format = 'json';
	public $customHeader = false;

	/**
	 * Send a response to the client
	 * @param integer $status The HTTP status code
	 * @param string $body The response
	 * @param string $content_type JSON or other
	 */
	//TODO: Return data according to setting on API Controller / abstraction or global config?
	public function sendResponse($status = 200, $body = '', $content_type = 'application/json')
	{
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
		header($status_header);
		header('Content-type: ' . $content_type);
		if ($this->customHeader)
			header($this->customHeader);

		if ($body != '') {
			$this->_renderOutput($body);
			exit;
		}
	}

	/**
	 * Return status message for code
	 * @param integer $status The HTTP status code
	 * @return string  The text of the HTTP status code
	 */
	private function _getStatusCodeMessage($status)
	{
		$codes = Array(
			200 => 'OK',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
		);
		return (isset($codes[$status])) ? $codes[$status] : '';
	}

	private function _renderOutput($output)
	{
		switch ($this->format) {
			case 'json' :
				echo json_encode($output);
				break;
			case 'xml' :
		}
	}
}
