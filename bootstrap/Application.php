<?php
namespace Core;

class Application{
    use Router, HttpRequest, View;
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }
    public function run(){
        
        $http_method = self::getMethod();
        $url_path = self::getPath();

        
        $callable = $this->match($http_method, $url_path);

        if(!$callable){
            throw new \Exception('404 Not Found', 404);
        }

        $class = "App\\Controllers\\".$callable['class'];
        if(!class_exists($class)){
            throw new \Exception('Class Does Not Found.', 500);
        }

        $method = $callable['method'];
        if(!is_callable($class, $method)){
            throw new \Exception("Method '$method' is not found in class '$callable[class]'", 500);
        }
        if(isset($_GET['route'])){unset($_GET['route']);}
        if(isset($_REQUEST['route'])){unset($_REQUEST['route']);}
        $class = new $class;
        $class->$method($this->request);
        return;        
    }

    private function match($method, $url)
    {
        $route = substr($url, strpos($url, '/', 1), strlen($url));
        $last_slash_pos = strripos($route, '/');
        $str_after_last_slash = substr($route, $last_slash_pos +1, strlen($route));
        $str_from_last_slash = substr($route, $last_slash_pos, strlen($route));
        $value_before_qt = substr($str_from_last_slash, 0, strpos($str_from_last_slash, '?', 1));

        foreach (self::$map[$method] as $uri=>$call){
            if (substr($url, -1) === '/' && $uri != '/'){
                $url = substr($url, 0, -1);
            }
            if ($value_before_qt === $uri && strpos($url, '?', 1)!=false){
                return $call;
            }
            if(is_numeric($str_after_last_slash)==1 && substr($route, 0, $last_slash_pos).'/{id}' === $uri){
                return $call;
            }
            if (substr($url, strpos($url, '/', 1),strlen($url)) === $uri){
                return $call;
            }
        }
        return false;
    }
}