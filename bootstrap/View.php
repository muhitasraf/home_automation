<?php 
namespace Core;

trait View{

    public function render($view, $params = []){
        $position = strpos($view, ".");
        if ($position){
            $view = str_replace(".", "/", $view);
        }
        if (is_readable(APP_ROOT."/resources/views/$view.php")){
            return $this->generateView($view, $params);
        }else{
            throw new \Exception("404 PAGE NOT FOUND", 404);
        }
    }

    private function generateView($view, $params){
        foreach($params as $key => $value){
            $$key = $value;
        }
        ob_start();
        require_once(APP_ROOT."/resources/views/master/header.php");
        require_once APP_ROOT."/resources/views/$view.php";
        require_once(APP_ROOT."/resources/views/master/footer.php");
        echo ob_get_clean();
        return true;
    }
}