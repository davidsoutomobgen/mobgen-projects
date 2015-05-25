<?php

/**
 * Description of Role
 *
 * @author kthermos
 */
class Role {

    const USER = 1;
    const CLIENT = 2;
    const DEV = 3;
    const ADMIN = 9;

    public function getRoles() {
        return array(
            self::USER => 'User',
            self::CLIENT => 'Client',
            self::DEV => 'Dev',
            self::ADMIN => 'Admin',
        );
    }

    public function toText($role) {
        switch ($role) {
            case self::USER:
                return 'User';
            case self::CLIENT:
                return 'Client';
            case self::DEV:
                return 'Dev';
            case self::ADMIN:
                return 'Admin';
            default:
                return false;
                break;
        }
    }

    public function explainRole($role) {
        switch ($role) {
            case self::USER:
                return 'This profile can SEE and EDIT content';
            case self::CLIENT:
                return 'This profile only can see content';
            case self::DEV:
                return 'This profile can do all, this profile only is available on development';
            case self::ADMIN:
                return 'You are God!';
            default:
                return false;
                break;
        }
    }

}