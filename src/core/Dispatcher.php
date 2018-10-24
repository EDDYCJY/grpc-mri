<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 20/10/18
 * Time: 下午10:08
 */

namespace mri\core;

use mri\core\grpc\Request;
use mri\core\grpc\Response;

class Dispatcher {

    public function handleRequest($controller, $action, $rawContent) {
        $request = new Request();
        $request->setRawContent($rawContent);
        $request->setController($controller);
        $request->setAction($action);

        return $request->params();
    }

    public function handleResponse($data) {
        if (is_null($data) || is_array($data) && count($data) == 0) {
            return '';
        }

        $response = new Response();
        $response->setData($data);
        return $response->params();
    }
}