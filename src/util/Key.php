<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 22/10/18
 * Time: 下午4:14
 */

namespace mri\util;

abstract class Key {

    public static function reset($datas) {
        return array_values($datas);
    }
}