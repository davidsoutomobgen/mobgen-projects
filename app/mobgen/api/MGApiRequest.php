<?php

/**
 * This file contains core behavior for MobgenApi Request.
 *
 * @author David Souto <david.souto@mobgen.com>
 * @link http://wiki.mobgendev.com
 */
class MGApiRequestException extends MGApiException {

}

/**
 * This class define the base behavior for the Api rest.
 *
 * @author David Souto <david.souto@mobgen.com>
 * @link http://wiki.mobgendev.com
 *
 *
 * */
abstract class MGApiRequest {

	protected $errors = null;

	/**
	 * @var array decoded data
	 */
	protected $data = null;

	public function setData($data) {

		if (!$data) {
			$this->errors = array("POST Data cannot be empty");
			return false;
		} else {
			if ($this->data = $this->decode($data)) {
				return true;
			} else {
				return false;
			}
		}
	}

	public function getData() {
		return $this->data;
	}

	public function getErrors() {
		return $this->errors;
	}

	/**
	 * return the decoded data
	 */
	abstract protected function decode($data);
}