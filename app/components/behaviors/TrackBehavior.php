<?php

/**
 * TrackBehavior Class
 *
 * @author    David Souto <david.souto@mobgen.com>
 * @date    18 May 2015
 */
class TrackBehavior extends BusinessLogicBehavior
{

	/**
	 * Adds this tracks related data
	 * @see CActiveRecord::getAttributes
	 * @param null $names
	 * @return mixed
	 */
	public function getAllAttributes($names = null)
	{
		$attrs = parent::getAllAttributes($names);


		if (isset($attrs["mp3"]) && $attrs["logo"] != '')
			$attrs["logo"] = Yii::app()->controller->createAbsoluteUrl("files".DS."projects".$attrs["logo"]);
		else
			unset($attrs["mp3"]);

        /* Fault Adjust Project type */
        /*
		if (isset($this->owner->relatedTracks) && $this->owner->relatedTracks) {
			$attrs["relatedTracks"] = array();
			foreach ($this->owner->relatedTracks as $track) {
				$attrs["relatedTracks"][] = (int)$track->id;
			}
		}
        */

		return $attrs;
	}

	/**
	 *
	 * @param $paramsArray Array of
	 * */
	public function doList($paramsArray) {
		$items = $this->owner->published()->findAll();
		return $items;
	}

}
