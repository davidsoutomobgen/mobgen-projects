<?php

/**
 * Base class to map the Mobgen's REST URL
 * TODO Enhance this class to avoid the inheritance and to allow dynamic check by properties (Event solution)
 * @author David Souto <david.souto@mobgen.com>
 */
class MGRestUrlRule extends CBaseUrlRule {

	public $connectionID;
	public $restResources;
	public $baseApiUrl = "api";

	public function createUrl($manager, $route, $params, $ampersand) {
		return false;
	}

	public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {

		if (!preg_match('{api\/\w+}', $pathInfo)) //TODO improve this part
			return false;

		$verb = $request->getRequestType();

		$paths = explode("/", $pathInfo);
		$resource = $paths[1];

		// ################# .:: GENERIC OPERATION  ::. #################

		switch ($verb) {
			case 'GET' :
				if (count($paths) == 2) {
					$_GET['resource'] = $resource;
                    if ($resource == 'all-inapps' || $resource == 'all-inapp')
                        return $this->baseApiUrl . '/showAll';
                    else
					    return $this->baseApiUrl . '/list';
				} else if (count($paths) > 2) {
					$_GET['resource'] = $resource;
					$_GET['id'] = $paths[2];
					return $this->baseApiUrl . '/view';
				}
				break;
			case 'PUT' :
				if (count($paths) == 2) {
					$_GET['resource'] = $resource;
					return $this->baseApiUrl . "/bulkUpdate";
				} else if (count($paths) > 2) {
					$_GET['resource'] = $resource;
					$_GET['id'] = $paths[2];
					return $this->baseApiUrl . "/update";
				}
				break;
			case 'POST' :
				if (count($paths) == 2) {
					$_GET['resource'] = $resource;
					return $this->baseApiUrl . "/create";
				} else if (count($paths) > 2) {
					return false;
				}

				break;
			case 'DELETE' :
				if (count($paths) == 2) {
					$_GET['resource'] = $resource;
					return $this->baseApiUrl . "/bulkDelete";
				} else if (count($paths) > 2) {
					$_GET['resource'] = $resource;
					$_GET['id'] = $paths[2];
					return $this->baseApiUrl . "/delete";
				}
				break;
			case 'OPTIONS' :
				//TODO define the correct action
				return $this->baseApiUrl . "/options";
				break;
			default :
				false;
		}
		return false;
	}

}
