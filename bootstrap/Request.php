<?php
namespace Core;
use stdClass;
class Request{
    use HttpRequest;
    private $data;

    public function __construct(){
        $this->data = new stdClass();
        $this->setData();
    }

    private function setData(){
        if(isset($_GET['route'])){unset($_GET['route']);}
        if(isset($_REQUEST['route'])){unset($_REQUEST['route']);}
        foreach($_REQUEST as $key=>$value){
            if ($this->getMethod()==='get') {                    
                $this->$key = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                $this->data->$key = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }elseif($this->getMethod()==='post'){
                foreach($_POST as $key=>$value){
                    $this->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    $this->data->$key = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }else{
                $this->$key = $value;
                $this->data->$key = $value;
            }
        }
    }

    public function data($val){
        return $val ? $this->data->$val : $this->data;
    }

}