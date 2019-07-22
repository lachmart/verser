<?php

namespace Lab\Enumeration;

/**
 * Description of Statim
 *
 * @author Petr
 */
class Statim {

    const RUNTINA = 0;
    const STATIM = 1;
    const VITINDI = 2;

    static function getData() {
        return [
            self::RUNTINA => 'RUTINA',
            self::STATIM => 'STATIM',
            self::VITINDI => 'VITINDI'
        ];
    }

    static function getDataRS() {
        return [
            self::RUNTINA => 'RUTINA',
            self::STATIM => 'STATIM'
        ];
    }

}
