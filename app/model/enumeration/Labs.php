<?php

namespace Lab\Enumeration;

/**
 * Description of Labs
 *
 * @author Petr Kobelka <info@petrkobelka.cz>
 */
class Labs {

    private static $data = [
        'ALL' => '--- Všechny laboratoře FNO ---',
        'HOK' => 'Hemato-onkologická klinika [HOK]',
        'LEM' => 'Laboratoř experimentální medicíny [LEM]',
        'OKB' => 'Oddělení klinické biochemie [OKB]',
        'FTO' => 'Transfúzní oddělení [FTO]',
        'GEN' => 'Ústav lékařské genetiky [GEN]',
        'IMU' => 'Ústav imunologie [IMU]',
        'MIK' => 'Ústav mikrobiologie [MIK]',
        'PAT' => 'Ústav patologie [PAT]',
        'USL' => 'Ústav soudního lékařství [USL]',
    ];

    static function getData() {
        return self::$data;
    }

}
