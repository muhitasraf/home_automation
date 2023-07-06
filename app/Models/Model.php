<?php
    
namespace App\Models;

use Core\DB;

class Model extends DB{
    protected $pdo;
    public function __construct() {
        $this->pdo = self::instance();
        $this->csrf_token_verification();
    }
    private function csrf_token_verification()
    {
        if ($_POST) {
            if (isset($_POST['_csrf'])) {
                if (!empty($_POST['_csrf']) && hash_equals($_SESSION['_csrf'], $_POST['_csrf'])) {
                    return;
                } else {
                    echo '<h3>This page has been expired!</h3>';
                    exit;
                }
            }else{
                echo '<h3>This page has been expired!</h3>';
                exit;
            }
        }
    }
}
