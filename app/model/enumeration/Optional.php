<?php

namespace Lab\Enumeration;

/**
 * Description of Optional
 *
 * @author Petr
 */
class Optional extends AbstractEnumeration {

    const Y = 'Y';
    const N = 'N';

    static function getData() {
        return [
            self::Y => 'ANO',
            self::N => 'NE'
        ];
    }

}
