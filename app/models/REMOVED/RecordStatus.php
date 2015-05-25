<?php

/**
 * Description of RecordStatus
 *
 * @author David Souto <david.souto@mobgen.com>
 * @date 06 June 2013
 */
class RecordStatus {

	//For basic use
	const DISABLED 		= 0; //Inactive
	const ENABLED 		= 1; //Active

	//For workflow use
	const DRAFT		 	= 10; //Concept
	const PENDING	 	= 11; //Pending validation, correction
	const REJECTED	 	= 12; //Cancelled
	const APPROVED 		= 13; //Done, completed, ready
	const PUBLISHED 	= 14;
	const UNPUBLISHED 	= 15;
	const ARCHIVED		= 16;
	const DELETED 		= 99; //Removed

	public function getRecordStatus() {
		return array(
			self::DISABLED 		=> 'Disabled',
			self::ENABLED 		=> 'Enabled',
			self::DRAFT			=> 'Draft',
			self::PENDING		=> 'Pending',
			self::REJECTED		=> 'Rejected',
			self::APPROVED		=> 'Approved',
			self::PUBLISHED 	=> 'Published',
			self::UNPUBLISHED 	=> 'Unpublished',
			self::ARCHIVED		=> 'Archived',
			self::DELETED 		=> 'Deleted',
		);
	}

	public function toString($status) {
		switch ($status) {
			case self::DISABLED:
				return 'Disabled';
			case self::ENABLED:
				return 'Enabled';
			case self::DRAFT:
				return 'Draft';
			case self::PENDING:
				return 'Pending';
			case self::REJECTED:
				return 'Rejected';
			case self::APPROVED:
				return 'Approved';
			case self::PUBLISHED:
				return 'Published';
			case self::UNPUBLISHED:
				return 'Unpublished';
			case self::ARCHIVED:
				return 'Archived';
			case self::DELETED:
				return 'Deleted';
			default:
				return false;
				break;
		}
	}

}