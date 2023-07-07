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
        $error = [];
        if(empty($input['outputName'])){
            $error +=['name'=> 'Name Field is empty!'];
        }
        if(empty($input['outputBoard'])){
            $error +=['board'=> 'Board ID is empty!'];
        }
        if(empty($input['outputGpio'])){
            $error +=['gpio'=> 'GPIO Field is empty!'];
        }

        if(empty($error)){
            $chaeck_name = DB::query("SELECT id, name, board, gpio FROM outputs WHERE name = '".$input['outputName']."'")->fetchAll();
            $chaeck_gpio = DB::query("SELECT id, name, board, gpio FROM outputs WHERE gpio = ".$input['outputGpio']." AND board = '".$input['outputBoard']."'")->fetchAll();
        }
        
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

    public function edit($request){
        dd($request);
        return view('home/create');
    }

    public function update(){
        $input = $_POST;
        $error = [];
        if(empty($input['outputName'])){
            $error +=['name'=> 'Name Field is empty!'];
        }
        if(empty($input['outputBoard'])){
            $error +=['board'=> 'Board ID is empty!'];
        }
        if(empty($input['outputGpio'])){
            $error +=['gpio'=> 'GPIO Field is empty!'];
        }

        if(empty($error)){
            $chaeck_name = DB::query("SELECT id, name, board, gpio FROM outputs WHERE name = '".$input['outputName']."'")->fetchAll();
            $chaeck_gpio = DB::query("SELECT id, name, board, gpio FROM outputs WHERE gpio = ".$input['outputGpio']." AND board = '".$input['outputBoard']."'")->fetchAll();
        }
        
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

    public function destroy($request){
        dd($_GET);
    }

    public function change_state(){
        $id = $_POST['id'];
        $state = $_POST['state'];
        $result = DB::table('outputs')->where('id',$id)->update(['id'=>$id,'state'=>$state]);
        if($result==true){
            $result = ['status'=>200, 'message'=>'Successfully'];
        }else{
            $result = ['status'=>422, 'message'=>'Unprocessable Entity'];
        }
        echo json_encode($result);
    }

    public function switch_list(){
        $all_switch = DB::table('outputs')->fetchAll();
        return view('home/switch_list',compact('all_switch'));
    }

    public function get_gpio_state(){
        $all_output = DB::table('outputs')->fetchAll();
        $result = [];
        foreach($all_output as $output){
            $result += [$output['gpio']=>$output['state']];
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result);
    }
}