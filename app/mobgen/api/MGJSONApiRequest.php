<?php

/**
 * This class implement a basic JSON protocol for the api request
 *
 * @author David Souto <david.souto@mobgen.com>
 * @link http://wiki.mobgendev.com
 * */
class MGJSONApiRequest extends MGApiRequest {

	/**
	 * return the decoded data
	 */
	protected function decode($data) {
		return CJSON::decode($data);
	}

}