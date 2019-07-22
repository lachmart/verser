<?php

namespace Krecek5\Util;

use Lab\Util\String;
use Nette\Utils\Strings;

/**
 * Util class for support better work with numbers
 *
 * @author Petr Kobelka <info@petrkobelka.cz>
 */
class Number {

    /**
     * format output number as price with spaces and correct number decimal pointer
     *
     * @param float $price
     * @return string
     */
    static function formatPrice($price, $decimal = 2, $currency = null) {
        return number_format($price, $decimal, ',', ' ') . ($currency ? '&nbsp;' . $currency : '');
    }

    /**
     * snitize number - odstrani non numeric chars a carky prevede na tecky
     *
     * @param string $number
     * @return float
     */
    static function normalize($number) {
        $num1 = \Nette\Utils\Strings::replace($number, '/[^0-9\,\.]+/', '');
        return strtr($num1, array(',' => '.'));
    }

    static function normalizeNull($val) {

        if (Strings::match($val, '/^0+$/')) {
            return 0;
        }

        return !$val ?
            null : self::normalize($val);
    }

}
