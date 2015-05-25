<?php

/**
 * Description of Language
 */
class Language {

    const NL = 1;
    const EN = 2;

    public static function available() {
        return array(
            array('id'=>self::NL, 'name'=>'Dutch'),
            array('id'=>self::EN, 'name'=>'English'),
        );
    }

    public static function id($language) {
        switch ($language) {
            case false :
                return false;
            case 'en' :
                return self::EN;
                break;
            case 'nl' :
            default:
                return self::NL;
                break;
        }
    }

    public static function lang($id) {
        switch ($id) {
            case false :
                return false;
            case self::EN :
                return 'English';
                break;
            case self::NL :
            default:
                return 'Dutch';
                break;
        }
    }
}

?>
