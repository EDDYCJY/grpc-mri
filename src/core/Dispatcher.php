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

    public function handleResponse($controller, $action,  $data) {
        $response = new Response();
        $response->setData($data);
        $response->setController($controller);
        $response->setAction($action);

        return $response->params();
    }
}