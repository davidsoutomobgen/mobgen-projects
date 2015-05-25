<?php

/**
 * This class implement a basic JSON protocol for the api response
 *
 * @author David Souto <david.souto@mobgen.com>
 * @link http://wiki.mobgendev.com
 * */
class MGJSONApiResponse extends MGApiResponse {

	const PREFERED_CONTENT_TYPE = 'application/json';

	public $customHeader = false;

	public function getContentType() {
		return self::PREFERED_CONTENT_TYPE;
	}

	protected function prepareContent($body) {
		return json_encode($body);
		//TODO: COMMENTED THIS BECAUSE IT CAUSE A MEMORY LIMIT FOR THE JSON WHEN THE AMOUNT OF DATA IS HUGE
//    	return CJSON::encode($body);
	}

}
