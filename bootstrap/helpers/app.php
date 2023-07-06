<?php

use Core\Application;

$app = new Application();

//This function can generate Url
if (!function_exists('route')) {
    function route($url=null) {
        return URL.$url;
    }
}

//This function rendering all view file
if (!function_exists('view')) {
    function view($view, $params = []): bool
    {
        global $app;
        return $app->render($view, $params);
    }
}

//This function dumps data and closed further execution
if (!function_exists('dd')) {
    function dd($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit();
    }
}

//This function redirect to given url
if (!function_exists('redirect')) {
    function redirect($url=null,$with=[]) {
        if ($with){
            with($with['with']);
        }
        return header('Location:'.URL.$url);
    }
}

//This function can pass data when redirect to another url
if (!function_exists('with')) {
    function with($with=null)
    {
        $errors = $with['errors'] ?? null;
        $inputs = $with['inputs'] ?? null;
        session('errors', $errors);
        session('inputs', $inputs);
    }
}

//This function save data to session
if (!function_exists('session')) {
    function session($key=null,$val=null)
    {
        if(is_array($key)){
             foreach ($key as $item=>$val){
                 $_SESSION[$item] = $val;
             }
        }else if(isset($key) && isset($val)){
            return $_SESSION[$key] = $val;
        }elseif(isset($key)){
            return $_SESSION[$key] ?? '';
        }
        return;
    }
}

//This function output a CSRF filed
if (!function_exists('_csrf')) {
    function _csrf()
    {
        $csrf_token = bin2hex(random_bytes(32));
        session('_csrf',$csrf_token);
        return '<input type="hidden" id="_csrf" name="_csrf" value='.$csrf_token.'>';
    }
}

//This function checked authentication
if (!function_exists('auth')) {
    function auth()
    {
        return session('logged_in');
    }
}

//This function return asset path
if (!function_exists('asset')) {
    function asset($path='') {
        return ASSET_URL.$path;
    }
}

// This function save all error in storage/logs
if(!function_exists('Logs')){
    function Logs($log_data='') {
        if (is_array($log_data)){
            foreach ($log_data as $log_txt) {
                if (is_array($log_data)){
                    return error_log("Erro : Can't write array to Log file!");
                }else{
                    return error_log($log_txt);
                }
            }
        } else {
            return error_log($log_data);
        }
    }
}