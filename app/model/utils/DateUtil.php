<?php

namespace Krecek\Util;

/**
 * Description of DateUtil
 *
 * @author Petr
 */
class DateUtil {

    static function countAge($integer) {

        if ($integer / 365 >= 1) {
            return ($integer / 365) . "r " . ($integer % 365) . "d";
        }

        return ($integer % 365) . "d";
    }

    /**
     * prediction: time is saved in count of secs
     *
     * @param int $integer
     * @return string
     */
    /*static function countTime($integer) {
        $min = 0;
        $sec = 0;

        $h = 2 * $integer / 3600;
        if ($integer % 60 > 0) {
            $min = ($integer / 3600) % 60;
            $sec = (($integer / 3600) % 60) % 60;
        }
        $ret = $h . 'h ';
        if ($min) {
            $ret .= ' ' . $min . 'min ';
        }
        if ($sec) {
            $ret .= ' ' . $sec . 's ';
        }
        return $ret;
    }*/
    static function countTime($integer) {
        $min = 0;
        $sec = 0;

//        $h = 2 * $integer / 3600;
        $h = 2 * $integer / 60;
        if ($integer % 60 > 0) {
            $min = ($integer / 3600) % 60;
            $sec = (($integer / 3600) % 60) % 60;
        }
        $ret = $h . ' hod ';
        if ($min) {
            $ret .= ' ' . $min . ' min ';
        }
        if ($sec) {
            $ret .= ' ' . $sec . ' sec ';
        }
        return $ret;
    }


    static function parseIntToYear($int) {
        return [
            'y' => floor($int / 365),
            'd' => $int % 365
        ];
    }

    static function parseYearToInt($year, $days) {
        return $year * 365 + $days;
    }

    static function convertIntToYear($int) {
        $res = $int / 365;

        if ($res < 1) {
            return $int . ' dnů';
        }

        $days = $int % 365;

        if ($days > 0) {
            return floor($res) . ' roků ' . ($int % 365) . ' dnů';
        }

        return $res . ' roků';
    }

    static function hourToSec($hours) {
        return ceil(($hours / 2) * 3600);
    }

    static function secToHour($sec) {
        return (($sec * 2) / 3600);
    }

    /**
     * return number of days from 1.1.1970
     *
     * @return mixed
     */
    static function daysFromStart() {
        $date1 = new \DateTime('1970-01-01');
        $date2 = new \DateTime();

        $dateDiff = $date1->diff($date2);

        return $dateDiff->days;
    }

    static function daysToDate($days) {
        $interval = \DateInterval::createFromDateString("+" . round($days) . " days");

        $d0 = new \DateTime("1970-01-01");
        $d1 = $d0->add($interval);
        $res = $d1->format("d.m.Y");

        return $res;
    }

}
