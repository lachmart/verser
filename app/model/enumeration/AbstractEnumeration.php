<?php

namespace Lab\Enumeration;

/**
 * Description of AbstractEnumeration
 *
 * @author Petr
 */
abstract class AbstractEnumeration {

    static function getValue($id) {
        if (isset(static::getData()[$id])) {
            return static::getData()[$id];
        }
        return null;
    }

    static function getValueReversed($id) {

        $array = array_flip(static::getData());

        if (isset($array[$id])) {
            return $array[$id];
        }
        return null;
    }

}
