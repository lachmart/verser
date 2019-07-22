<?php

namespace Lab\Util;

class DatabaseUtil {

    public static function activeRowsToArray($selection) {
        $ret = [];

        foreach ($selection as $row) {
            $ret[] = $row->toArray();
        }
        return $ret;
    }

}