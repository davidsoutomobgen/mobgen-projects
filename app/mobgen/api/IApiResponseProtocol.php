<?php

/**
 * This file contains core interfaces for MobgenApi.
 *
 * @author David Souto <david.souto@mobgen.com>
 * @link http://wiki.mobgendev.com
 */

/**
 * IApiResponseProtocol is the interface that all protocol components must implement.
 *

 * @author David Souto <david.souto@mobgen.com>
 * @package mobgen.api
 * @since 1.0
 */
interface IApiResponseProtocol {

	/**
	 * set up custom headers for the response.
	 */
	public function setCustomHeaders($headers);

	/**
	 * send a massage using a specific protocol (HTTP1.0, HTTP1.1, custom protocol and so on)
	 */
	public function sendMessage($status, $body, $content_type);
}
