<?php

namespace Lab\Util;

/**
 * Description of DataTable
 *
 * @author Petr
 */
class DataTable {

    static function getSort($columns, $order) {
        $sortBy = [];
        foreach ($order as $oItem) {
            $sortBy[$columns[$oItem['column']]['data']] = $oItem['dir'];
        }
        return $sortBy;
    }

}
