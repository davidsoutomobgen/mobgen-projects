<?php

/**
 * Description of ApiUrlManager
 */
class ApiUrlRule extends MGRestUrlRule
{

	public function createUrl($manager, $route, $params, $ampersand)
	{
		return parent::createUrl($manager, $route, $params, $ampersand);
	}

	public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
	{
		Yii::trace("$pathInfo", "debugtrace");
		if (!preg_match('{api\/\w+}', $pathInfo)) {
			return false;
		}

		// isRest defines the nature of a call : rest OR not rest
		$_GET['isRest'] = false;

		$aparams = explode("/", $pathInfo);

		// Wrong api call
		if ('POST' == $request->getRequestType() && isset($aparams[2]) && is_numeric($aparams[2])) {
			return false;
		}

		// ################# .:: CUSTOM URL ::. #################
		switch ($request->getRequestType()) {
			case 'GET':
				switch ($aparams[1]) {
					case 'getBio':
						return "api/bio";
					case 'getSearchTag':
						return "api/searchTag";
					default:
						break;
				}
				break;
			case 'PUT':
				switch ($aparams[1]) {
					default:
						break;
				}
				break;
			case 'POST':
				switch ($aparams[1]) {
					default:
						break;
				}
				break;
			default:
				break;
		}

		// If the custom urls don't match, it's a REST operation
		$_GET['isRest'] = true;

		return parent::parseUrl($manager, $request, $pathInfo, $rawPathInfo);
	}
}