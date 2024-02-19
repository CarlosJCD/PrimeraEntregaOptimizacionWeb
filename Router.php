<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];
    public array $putRoutes = [];
    public array $deleteRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function put($url, $fn)
    {
        $this->putRoutes[$url] = $fn;
    }

    public function delete($url, $fn)
    {
        $this->deleteRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } elseif($method === 'POST') {
            $fn = $this->postRoutes[$url_actual] ?? null;
        } elseif($method === 'PUT') {
            $fn = $this->putRoutes[$url_actual] ?? null;
        } elseif($method === 'DELETE') {
            $fn = $this->deleteRoutes[$url_actual] ?? null;
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            header("Location: /404");
        }
    }

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        $url_actual = $_SERVER['PATH_INFO'] ?? '/';

        include_once __DIR__ . '/views/layout.php';
    }
}
