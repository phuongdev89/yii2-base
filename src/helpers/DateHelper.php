<?php

namespace phuongdev89\base\helpers;

use DateTime;

class DateHelper
{

    /**
     * @param        $current_date
     * @param string $source_format
     * @param string $destination_format
     *
     * @return string
     */
    public static function format($current_date, string $source_format = 'Y-m-d', string $destination_format = 'd-m-Y'): string
    {
        $date = DateTime::createFromFormat($source_format, $current_date);
        if (!$date) {
            return $current_date;
        } else {
            return $date->format($destination_format);
        }
    }

    /**
     * @param null $seconds
     *
     * @return bool
     */
    public static function isWeekend($seconds = null): bool
    {
        if ($seconds == null) {
            $seconds = time();
        }
        return in_array(date('w', $seconds), [
            0,
            6,
        ]);
    }

    /**
     * @return array
     *
     * @datetime 1/2/2023 11:53 PM
     * @author   Phuong Dev <phuongdev89@gmail.com>
     */
    public static function dateRangeThisWeek(): array
    {
        return [
            'monday' => strtotime('monday this week'),
            'sunday' => strtotime('sunday this week') + 86399
        ];
    }

    /**
     * @return array
     *
     * @datetime 1/2/2023 11:53 PM
     * @author   Phuong Dev <phuongdev89@gmail.com>
     */
    public static function dateRangeThisMonth(): array
    {
        return [
            'start' => strtotime(date('Y-m-01 00:00:00')),
            'end' => strtotime(date('Y-m-t 23:59:59'))
        ];
    }
}
