<?php
    
namespace App\Models;

class Home extends Model {
    protected $pdo;
    public function __construct() {
        parent::__construct();
    }

    public function test(){
        $sql =  $this->pdo->query("SELECT * FROM products");
        return $sql;
    }
}
