<?php

namespace Lab\Enumeration;

/**
 * Description of Availability
 *
 * @author Petr
 */
class Availability {

    static function getData() {
        return [
            'D' => 'Denně',
            'W' => 'Týdně',
            'M' => 'Měsíčně',
            '1' => 'Pondělí',
            '2' => 'Úterý',
            '3' => 'Středa',
            '4' => 'Čtvrtek',
            '5' => 'Pátek',
            'X' => 'Domluva',
            'Y' => 'Pondělí - pátek',
            'A' => 'Pondělí a středa a pátek',
            'C' => 'Pondělí a čtvrtek',
            'B' => 'Úterý a čtvrtek'
        ];
    }

}
