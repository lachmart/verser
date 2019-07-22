<?php

namespace Lab\Enumeration;

/**
 * Description of Gender
 *
 * @author Petr
 */
class Gender extends AbstractEnumeration {

    const MF = 0;
    const M = 1;
    const F = 2;

    static function getData() {
        return [
            self::MF => 'M + F',
            self::M => 'M',
            self::F => 'F'
        ];
    }

}
