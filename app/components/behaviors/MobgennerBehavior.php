<?php

/**
 * MobgennerBehavior Class
 *
 * @author    David Souto <david.souto@mobgen.com>
 * @date    18 May 2015
 */
class MobgennerBehavior extends BusinessLogicBehavior
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
