<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 22/10/18
 * Time: 下午4:42
 */

namespace mri\core\grpc;

use swoole_http_response;

class Header {

    private $response = null;

    public function setResponse(swoole_http_response $response) {
        $this->response = $response;

        return $this;
    }

    public function getResponse() : swoole_http_response {
        return $this->response;
    }

    public function init() {
        $this->response->header('content-type', 'application/grpc');
        $this->response->header('trailer', 'grpc-status, grpc-message');

        return $this;
    }

    public function status($status, $message) {
        $this->response->trailer('grpc-status', $status);
        $this->response->trailer('grpc-message', $message);

        return $this;
    }
}