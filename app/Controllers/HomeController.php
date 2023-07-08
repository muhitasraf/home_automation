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
        $error = []; $chaeck_name=''; $chaeck_gpio='';
        if(empty($input['outputName'])){
            $error +=['name'=> 'Name Field is empty!'];
        }
        if(empty($input['outputBoard'])){
            $error +=['board'=> 'Board ID is empty!'];
        }
        if($input['outputGpio']==''){
            $error +=['gpio'=> 'GPIO Field is empty!'];
        }

        if(empty($error)){
            $chaeck_name = DB::query("SELECT id, name, board, gpio FROM outputs WHERE name = '".$input['outputName']."'")->fetchAll();
            $chaeck_gpio = DB::query("SELECT id, name, board, gpio FROM outputs WHERE gpio = ".$input['outputGpio']." AND board = '".$input['outputBoard']."'")->fetchAll();
        }
        
        if(!empty($chaeck_name)){
            $error +=['name'=> 'Name already exist!'];
        }
        if($chaeck_gpio==''){
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
        $id = $request['id'];
        $switch_data = DB::query("SELECT id, name, board, gpio, state FROM outputs WHERE id = $id")->fetch();
        return view('home/edit',compact('switch_data'));
    }

    public function update(){
        
        $input = $_POST;
        $id = $input['id'];
        $error = []; $chaeck_name=''; $chaeck_gpio='';
        if(empty($input['outputName'])){
            $error +=['name'=> 'Name Field is empty!'];
        }
        if(empty($input['outputBoard'])){
            $error +=['board'=> 'Board ID is empty!'];
        }
        if($input['outputGpio']==''){
            $error +=['gpio'=> 'GPIO Field is empty!'];
        }
        if(empty($error)){
            $chaeck_name = DB::query("SELECT id, name, board, gpio FROM outputs WHERE id NOT IN($id) AND name = '".$input['outputName']."'")->fetchAll();
            $chaeck_gpio = DB::query("SELECT id, name, board, gpio FROM outputs WHERE id NOT IN($id) AND gpio = ".$input['outputGpio']." AND board = ".$input['outputBoard'])->fetchAll();
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
            
            $result = DB::table('outputs')->where('id',$id)->update($outputData);
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
        $id = $request['id'];
        $result = DB::table('outputs')->where('id',$id)->delete();
        if($result==true){
            $result = ['status'=>200, 'message'=>'Successfully Insert'];
        }else{
            $result = ['status'=>422, 'message'=>'Unprocessable Entity'];
        }
        return redirect('switch_list');
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
            $result += [$output['gpio']=>$this->test_input($output['state'])];
        }
        //header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result);
    }
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}