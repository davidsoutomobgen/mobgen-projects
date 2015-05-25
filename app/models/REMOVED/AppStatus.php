<?php

/**
 * Description of AppStatus
 *
 * @author kthermos
 */
class AppStatus {

    const OK = 1;
    const UPDATE = 2;
    const WIPEDOCS = 3;
    const WIPEFEEDS = 4;
    const WIPEALL = 5;
    const NOAUTH = 9;

    public static function message($status) {
        switch ($status) {
            case self::OK:
            case self::WIPEDOCS:
            case self::WIPEFEEDS:
            case self::WIPEALL:
                return '';
                break;
            case self::UPDATE:
                return 'Please update the software to the latest version.';
        }
    }
    
    public static function text($status) {
        switch ($status) {
            case self::OK:
                return 'ok';
                break;
            case self::WIPEDOCS:
                return 'wipedocs';
                break;
            case self::WIPEFEEDS:
                return 'wipefeeds';
                break;
            case self::WIPEALL:
                return 'wipeall';
                break;
            case self::UPDATE:
                return 'update';
                break;
        }
    }

}
