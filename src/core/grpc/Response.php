<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 19/10/18
 * Time: 下午5:11
 */

namespace mri\core\grpc;

use \Google\Protobuf\Internal\Message;

class Response {

    protected $data;

    public function setData(Message $data) {
        $this->data = $data;

        return $this;
    }

    public function getData() {
        return $this->data;
    }

    public function params() {
        return $this->serializeMessage($this->getData());
    }

    protected function serializeMessage($message) {
        return Parser::serializeMessage($message);
    }
}