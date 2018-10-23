<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 19/10/18
 * Time: 下午4:28
 */

function toUnderline($value)
{
    return strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '-$1', $value));
}

function toUcWordHump($value)
{
    $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
        return strtoupper($matches[2]);
    }, $value);

    return ucwords($str);
}

function toHump($value)
{
    $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
        return strtoupper($matches[2]);
    }, $value);

    return $str;
}