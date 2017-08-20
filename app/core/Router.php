<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 19.08.17
 * Time: 16:47
 */

namespace core;


class Router
{
    protected $namespacePath = 'controllers\\';

    public function route($uri) {
        $parts = parse_url($uri);

        $url = trim($parts['path'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        if(isset($url[0]) && !empty($url[0])) {
            $class = $this->namespacePath . ucfirst($url[0]) . 'Controller';
            $reflectionClass = new \ReflectionClass($class);

            if(class_exists($class) && $reflectionClass->IsInstantiable()) {
                $object = new $class;

                if(isset($url[1]) && !empty($url[1])) {
                    if(method_exists($object, $url[1])) {
                        $object->$url[1]();
                    } else {
                        $this->pageNotFound();
                    }
                } else {
                    $object->index();
                }
            } else {
                $this->pageNotFound();
            }
        } else {
            $object = new \controllers\IndexController();
            $object->index();
        }
    }

    protected function pageNotFound() {
        $object = new \controllers\ErrorController();
        $object->index();
    }
}