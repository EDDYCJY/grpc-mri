<?php
/**
 * Created by PhpStorm.
 * User: eddycjy
 * Date: 19/10/18
 * Time: 下午4:35
 */

namespace mri\core\grpc;

use ReflectionClass;

class Request {

    const GETTER_PREFIX = 'get';

    const REQUEST_SUFFIX = 'Request';

    protected $rawContent;

    protected $controller;

    protected $action;

    public function setRawContent($rawContent) {
        $this->rawContent = $rawContent;

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

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function params() {
        $className = $this->getClassName($this->getController(), $this->getAction());
        $message = $this->deserializeMessage($className, $this->getRawContent());
        $requestFunctions = [];
        $reflectionObject = new ReflectionClass($className);
        $properties = $reflectionObject->getProperties();
        foreach ($properties as $property) {
            $key = toHump($property->getName());
            $value = self::GETTER_PREFIX . ucwords($key);
            $requestFunctions[$key] = $value;
        }

        $params = [];
        foreach ($requestFunctions as $field => $function) {
            $params[$field] = $message->$function();
        }

        return $params;
    }

    protected function deserializeMessage($className, $rawContent) {
        return Parser::deserializeMessage([$className, null], $rawContent);
    }

    private function getClassName($controller, $action) {
        return toUcWordHump($controller) . '\\' . toUcWordHump($action) . self::REQUEST_SUFFIX;
    }
}