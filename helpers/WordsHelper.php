<?php

namespace app\helpers;

class WordsHelper
{
    public static function declinationAfterNumber($num, $titles) {
        $cases = array(2, 0, 1, 1, 1, 2);

        return $num . " " . $titles[($num % 100 > 4 && $num % 100 < 20) ? 2 : $cases[min($num % 10, 5)]];
    }
}