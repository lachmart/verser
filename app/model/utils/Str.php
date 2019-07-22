<?php

//namespace Lab\Util;

/**
 * Description of Str util
 *
 * @author Petr
 */
class Str {

    /**
     *
     * @param type $str
     * @return type
     */
    static function in($str) {
        return $str;
        //return iconv('cp1250', 'utf-8', $str);
    }

    /**
     *
     * @param type $str
     * @return type
     */
    static function out($str) {
        return $str;
        //return iconv('utf-8', 'cp1250', $str);
    }

}
