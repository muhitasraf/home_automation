<?php
namespace Core;
trait HttpRequest
{
    public function getPath()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

}