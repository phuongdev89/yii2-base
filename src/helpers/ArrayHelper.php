<?php

namespace phuongdev89\base\helpers;
class ArrayHelper extends \yii\helpers\ArrayHelper
{

    /**
     * @param $array
     * @param $from
     * @param $to
     * @param $attribute
     *
     * @return array
     */
    public static function mapAttribute($array, $from, $to, $attribute): array
    {
        $data = self::map($array, $from, $to);
        $response = [];
        foreach ($data as $key => $datum) {
            $response[$key] = [$attribute => $datum];
        }
        return $response;
    }

    /**
     * @param $array
     * @param $keys
     *
     * @return mixed
     */
    public static function unsetr($array, $keys)
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }
        foreach ($keys as $key) {
            unset($array[$key]);
        }
        return $array;
    }

    /**
     * @param array $source
     * @param array $destination
     * @param string $attribute
     *
     * @return array
     */
    public static function optionAttribute(array $source, array $destination, string $attribute): array
    {
        $response = [];
        foreach ($source as $key => $datum) {
            $response[$key] = [$attribute => $destination[$key]];
        }
        return $response;
    }
}
