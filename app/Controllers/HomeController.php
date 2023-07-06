<?php

namespace App\Controllers;

use App\Models\Home;
use Core\DB;
use Core\Request;

class HomeController extends Controller{
    public $home;
    public function __construct(){
        $this->home = new Home();
    }
    public function index(){
        $esp_outputs = DB::query("SELECT id, name, board, gpio, state FROM outputs ORDER BY board")->fetchAll();
        $esp_boards = DB::query("SELECT board, last_request FROM boards ORDER BY board")->fetchAll();
        return view('home/index',compact('esp_outputs','esp_boards'));
    }

    public function create(){
        return view('home/create');
    }

    public function store(){
        $input = $_POST;
        $chaeck_name = DB::query("SELECT id, name, board, gpio FROM outputs WHERE name = '".$input['outputName']."'")->fetchAll();
        $chaeck_gpio = DB::query("SELECT id, name, board, gpio FROM outputs WHERE gpio = ".$input['outputGpio']." AND board = '".$input['outputBoard']."'")->fetchAll();
        $error = [];
        if(!empty($chaeck_name)){
            $error +=['name'=> 'Name already exist!'];
        }
        if(!empty($chaeck_gpio)){
            $error +=['gpio'=> 'GPIO already exist!'];
        }

        if(empty($error)){
            $outputData = [
                'name' => $input['outputName'],
                'board' => $input['outputBoard'],
                'gpio' => $input['outputGpio'],
                'state' => $input['outputState'],
            ];
            
            $result = DB::table('outputs')->insert($outputData);
            if($result==true){
                $result = ['status'=>200, 'message'=>'Successfully Insert'];
            }else{
                $result = ['status'=>422, 'message'=>'Unprocessable Entity'];
            }
            echo json_encode($result);
        }else{
            echo json_encode(['status'=>403,'message'=>$error]);
        }
        
    }
}