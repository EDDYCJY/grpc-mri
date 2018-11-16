<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 19/10/18
 * Time: 下午4:28
 */

namespace mri\util;

abstract class Convert {

    public static function toUnderline($value)
    {
        return strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '-$1', $value));
    }

    public static function toUcWordHump($value)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $value);

        return ucwords($str);
    }

    public static function toHump($value)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $value);

        return $str;
    }
}

