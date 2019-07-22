<?php

namespace Lab\Util;

/**
 * Description of String
 *
 * @author Petr
 */
class String {

    static function nullToEmptyString($val) {
        if ($val == null) {
            return '';
        }

        return $val;
    }

    static function emptyStringToNull($val) {
        if ($val == '') {
            return null;
        }

        return $val;
    }

}
