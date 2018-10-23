<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 19/10/18
 * Time: 下午4:01
 */

namespace mri\core\grpc;

use mri\util\Convert;

class Router {

    protected $uri;

    public function setURI($uri) {
        $this->uri = trim($uri, '/');

        return $this;
    }

    public function route() {
        if (empty($this->uri)) {
            return null;
        }

        $paths = explode('/', $this->uri);
        if (count($paths) < 2) {
            return null;
        }

        $action = $paths[1];
        $controller = explode('.', $paths[0])[1];

        return [
            'action' => Convert::toUnderline($action),
            'controller' => Convert::toUnderline($controller),
        ];
    }
}