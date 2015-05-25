<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    public function authenticate() {
        $user = Webuser::model()->findByAttributes(array('username' => $this->username));
        $ph = new PasswordHash(Yii::app()->params['phpass']['iteration_count_log2'], Yii::app()->params['phpass']['portable_hashes']);

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!$ph->CheckPassword($this->password, $user->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $user->last_login = date(DATE_ISO8601);
            $user->saveAttributes(array('last_login'));
            $this->setState('role', $user->role);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

}