<?php

namespace phuongdev89\base\helpers;

class NumberHelper
{

    /**
     * @param int $length
     *
     * @return string
     */
    public static function random(int $length = 6): string
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param $amount
     *
     * @return float
     */
    public static function amount($amount): float
    {
        return round($amount / 10000, 2);
    }

    /**
     * @param $nums
     *
     * @return int
     */
    public static function sum_of_digits($nums): int
    {
        $digits_sum = 0;
        for ($i = 0; $i < strlen($nums); $i++) {
            $digits_sum += $nums[$i];
        }
        return $digits_sum;
    }

    /**
     * @param $numstring
     *
     * @return string
     */
    public static function dec2hex($numstring): string
    {
        if (extension_loaded('bcmath')) {
            return self::bcdechex($numstring);
        }
        $numstring = sprintf('%0.0f', $numstring);
        $chars = "0123456789abcdefghijklmnopqrstuvwxyz";
        $tostring = substr($chars, 0, 16);
        $length = strlen($numstring);
        $result = '';
        $number = [];
        for ($i = 0; $i < $length; $i++) {
            $number[$i] = strpos($chars, $numstring{$i});
        }
        do {
            $divide = 0;
            $newlen = 0;
            for ($i = 0; $i < $length; $i++) {
                $divide = $divide * 10 + $number[$i];
                if ($divide >= 16) {
                    $number[$newlen++] = (int)($divide / 16);
                    $divide = $divide % 16;
                } elseif ($newlen > 0) {
                    $number[$newlen++] = 0;
                }
            }
            $length = $newlen;
            $result = $tostring{$divide} . $result;
        } while ($newlen != 0);
        return $result;
    }

    /**
     * @param $dec
     *
     * @return string
     */
    public static function bcdechex($dec): string
    {
        $hex = '';
        do {
            $last = bcmod($dec, 16);
            $hex = dechex($last) . $hex;
            $dec = bcdiv(bcsub($dec, $last), 16);
        } while ($dec > 0);
        return $hex;
    }

    /**
     * @param $number
     *
     * @return string
     */
    public static function largeNumber($number): string
    {
        return number_format($number, 0, '', '');
    }

    /**
     * @param     $number
     * @param int $dec
     *
     * @return string
     */
    public static function bigintFormat($number, int $dec = 0): string
    {
        if ($dec > 0) {
            return number_format($number, $dec, '.', '');
        } else {
            return number_format($number, $dec, '', '');
        }
    }
}
