<?php
/*
  +----------------------------------------------------------------------+
  | Swoole-Etcd-Client                                                   |
  +----------------------------------------------------------------------+
  | This source file is subject to version 2.0 of the Apache license,    |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.apache.org/licenses/LICENSE-2.0.html                      |
  | If you did not receive a copy of the Apache2.0 license and are unable|
  | to obtain it through the world-wide-web, please send a note to       |
  | license@swoole.com so we can mail you a copy immediately.            |
  +----------------------------------------------------------------------+
  | Author: Twosee <twose@qq.com>                                        |
  +----------------------------------------------------------------------+
*/
namespace mri\core\grpc;

class Parser
{
    public static function pack(string $data): string
    {
        return $data = pack('CN', 0, strlen($data)) . $data;
    }
    public static function unpack(string $data): string
    {
        // it's the way to verify the package length
        // 1 + 4 + data
        // $len = unpack('N', substr($data, 1, 4))[1];
        // assert(strlen($data) - 5 === $len);
        return $data = substr($data, 5);
    }

    public static function serializeMessage($data)
    {
        if (method_exists($data, 'encode')) {
            $data = $data->encode();
        } elseif (method_exists($data, 'serializeToString')) {
            $data = $data->serializeToString();
        } else {
            /** @noinspection PhpUndefinedMethodInspection */
            $data = $data->serialize();
        }
        return self::pack($data);
    }

    public static function deserializeMessage($deserialize, string $value)
    {
        if (empty($value)) {
            return null;
        } else {
            $value = self::unpack($value);
        }
        if (is_array($deserialize)) {
            list($className, $deserializeFunc) = $deserialize;
            /** @var $obj \Google\Protobuf\Internal\Message */
            $obj = new $className();
            if ($deserializeFunc && method_exists($obj, $deserializeFunc)) {
                $obj->$deserializeFunc($value);
            } else {
                /** @noinspection PhpUndefinedMethodInspection */
                $obj->mergeFromString($value);
            }
            return $obj;
        }
        return call_user_func($deserialize, $value);
    }
}