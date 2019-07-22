<?php

namespace Lab\Enumeration;

/**
 * Description of Statim
 *
 * @author Petr
 */
class Rutina {

    const W = 'W';
    const D = 'D';
    const H = 'H';
    const I = 'I';
    const M = 'M';
//lukeš doplněno dle parseru nenalezených dat
    const Y = 'Y';
    const X = 'X';    

    static function getData() {
        return [
            self::W => 'týden',
            self::D => 'den',
            self::H => 'hodina',
            self::I => 'minuta',
            self::M => 'měsíc',
            self::Y => 'rok',
            self::X => 'neuvedeno'            
        ];
    }

}
