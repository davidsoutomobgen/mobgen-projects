<?php

class EHashPasswordBehavior extends CActiveRecordBehavior {
	public function beforeSave($event) {
        //var_dump($_POST);
      //  var_dump($event->sender);
		$ph = new PasswordHash(Yii::app()->params['phpass']['iteration_count_log2'], Yii::app()->params['phpass']['portable_hashes']);
		$post = Yii::app()->request->getPost(get_class($this->getOwner()));
		$this->getOwner()->password = isset($post['password']) && !empty($post['password']) ? $ph->HashPassword($post['password']) : $this->getOwner()->password;
		return parent::beforeSave($event);
	}
}
