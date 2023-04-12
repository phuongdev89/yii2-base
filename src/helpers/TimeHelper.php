<?php

namespace phuongdev89\base\helpers;

class TimeHelper
{

    /**
     * @param int $seconds
     *
     * @return string
     */
    public static function remaining(int $seconds): string
    {
        $day = floor($seconds / 86400);
        $hour = floor(($seconds - $day * 86400) / 3600);
        $minute = floor(($seconds - $day * 86400 - $hour * 3600) / 60);
        $second = $seconds - $day * 86400 - $hour * 3600 - $minute * 60;
        $day = $day >= 10 ? $day : '0' . $day;
        $hour = $hour >= 10 ? $hour : '0' . $hour;
        $minute = $minute >= 10 ? $minute : '0' . $minute;
        $second = $second >= 10 ? $second : '0' . $second;
        $result = $day != 0 ? $day . ' day(s) ' : '';
        $result .= $hour != 0 ? $hour . 'h ' : '';
        $result .= $minute != 0 ? $minute . 'm ' : '';
        $result .= $second . 's';
        return $result;
    }

    /**
     * @param int $seconds
     *
     * @return string
     */
    public static function happen(int $seconds): string
    {
        if ($seconds > time()) {
            return 'Just now';
        }
        $timed = time() - $seconds;
        if ($timed > 60) {
            if ($timed > 3600) {
                if ($timed > 86400) {
                    if ($timed > 604800) {
                        return floor($timed / 604800) . ' weeks ago';
                    } else {
                        return floor($timed / 86400) . ' days ago';
                    }
                } else {
                    return floor($timed / 3600) . ' hours ago';
                }
            } else {
                return floor($timed / 60) . ' minutes ago';
            }
        } else {
            return $timed . ' seconds ago';
        }
    }
}
