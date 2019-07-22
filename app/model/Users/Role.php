<?php

namespace Lab\Users;

/**
 * Description of Labs
 *
 * @author Petr Kobelka <info@petrkobelka.cz>
 */
class Role {

    const USER = 0;
    const ADMIN = 1;

    private static $data = [
        self::USER => 'Uživatel',
        self::ADMIN => 'Administrátor'
    ];

    static function getData() {
        return self::$data;
    }

}
