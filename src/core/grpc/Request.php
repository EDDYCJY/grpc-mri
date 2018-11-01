<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 19/10/18
 * Time: 下午4:35
 */

namespace mri\core\grpc;

use mri\util\Convert;

class Request {

    const REQUEST_SUFFIX = 'Request';

    const CLIENT_SUFFIX = 'Client';

    protected $rawContent;

    protected $module;

    protected $controller;

    protected $action;

    public function setRawContent($rawContent) {
        $this->rawContent = $rawContent;

        return $this;
    }

    public function setModule($module) {
        $this->module = $module;

        return $this;
    }

    public function setController($controller) {
        $this->controller = $controller;

        return $this;
    }

    public function setAction($action) {
        $this->action = $action;

        return $this;
    }

    public function getRawContent() {
        return $this->rawContent;
    }

    public function getModule() {
        return $this->module;
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function params() {
        $className = $this->getRequestClass($this->getModule(), $this->getController(), $this->getAction());
        if (is_null($className)) {
            $className = $this->getDefaultClass($this->getController(), $this->getAction());
        }

        return $this->deserializeMessage($className, $this->getRawContent());
    }

    protected function deserializeMessage($className, $rawContent) {
        return Parser::deserializeMessage([$className, null], $rawContent);
    }

    private function getRequestClass($module, $controller, $action) {
        $name = Convert::toUcWordHump($module) . '\\' . Convert::toUcWordHump($controller) . self::CLIENT_SUFFIX;
        $reflection = new \ReflectionClass($name);
        $params = $reflection->getMethod(Convert::toUcWordHump($action))->getParameters();
        $class = $params[0]->getClass()->getName();

        return $class;
    }

    private function getDefaultClass($controller, $action) {
        return Convert::toUcWordHump($controller) . '\\' . Convert::toUcWordHump($action) . self::REQUEST_SUFFIX;
    }
}