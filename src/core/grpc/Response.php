<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 19/10/18
 * Time: 下午5:11
 */

namespace mri\core\grpc;

class Response {

    const RESPONSE_SUFFIX = 'Response';

    protected $controller;

    protected $action;

    protected $data;

    public function setController($controller) {
        $this->controller = $controller;

        return $this;
    }

    public function setAction($action) {
        $this->action = $action;

        return $this;
    }

    public function setData($data) {
        $this->data = $data;

        return $this;
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function getData() {
        return $this->data;
    }

    public function params() {
        $className = $this->getClassName($this->getController(), $this->getAction());
        $message = new $className;
        $data = $this->encode($this->data);
        $message->mergeFromJsonString($data);

        return $this->serializeMessage($message);
    }

    protected function serializeMessage($message) {
        return Parser::serializeMessage($message);
    }

    protected function getClassName($controller, $action) {
        return toUcWordHump($controller) . '\\' . toUcWordHump($action) . self::RESPONSE_SUFFIX;
    }

    protected function encode($data) {
        return json_encode($data);
    }
}