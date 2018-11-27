<?php

namespace Base;

class Router
{
    protected $routes;
    protected $request;
    protected $url;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->url = (empty($this->request->redirectUrl)) ? '/' : rtrim($this->request->redirectUrl, '/');
    }

    protected function findMatch() {
        $result = [];
        foreach ($this->routes as $route) {
            if ($route['method'] == strtolower($this->request->requestMethod)) {
                if ($route['pattern'] == $this->url) {
                    $result['action'] = $route['action'];
                } else {
                    $regexp = '/^' . str_replace(['/', '{id}'], ['\/', '(\d+)'], $route['pattern']) . '$/';
                    if (preg_match($regexp, $this->url, $matches) > 0) {
                        $result['action'] = $route['action'];
                        $result['id'] = $matches[1];
                    }
                }
            }
        }
        return $result;
    }

    protected function callPrepare($action, $id) {
        $actions = explode('@', $action);
        list($controller, $method) = $actions;
        $controller = ucfirst($controller);
        $class = '\App\Controllers\\' . $controller;
        $object = new $class($this->request);
        $arguments = [];
        if ($id) {
            $arguments['id'] = $id;
        }
        $result = [$object, $method, $arguments];
        return $result;
    }

    public function get($pattern, $action)
    {
        $this->routes[] = [
            'pattern' => $pattern,
            'method' => 'get',
            'action' => $action,
        ];
    }

    public function post($pattern, $action)
    {
        $this->routes[] = [
            'pattern' => $pattern,
            'method' => 'post',
            'action' => $action,
        ];
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function run() {
        $matchedRoute = $this->findMatch();
        if (count($matchedRoute) > 0) {
            $action = isset($matchedRoute['action']) ? $matchedRoute['action'] : null;
            $id = isset($matchedRoute['id']) ? $matchedRoute['id'] : null;
            if (preg_match('/@/', $action)) {
                list($object, $method, $params) = $this->callPrepare($action, $id);
                call_user_func_array([$object, $method], $params);
            } else {
                header("{$this->request->serverProtocol} 404 Not Found");
            }
        } else {
            header("{$this->request->serverProtocol} 404 Not Found");
        }
    }
}
