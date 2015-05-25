<?php

/**
 * TypeBehavior Class
 *
 * @author    David Souto <david.soutok@mobgen.com>
 * @date    28 April 2015
 */
class ProjectBehavior extends BusinessLogicBehavior
{
	/**
	 *
	 * @param $paramsArray Array of
	 * */
	public function doList($paramsArray) {
		$items = $this->owner->published()->findAll();
		return $items;
	}

}
