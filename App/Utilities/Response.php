<?php
namespace App\Utilities;
class Response
{
    public static function respond($data,$status_code)
    {
        header("Content-Type: application/json");
        header("http 1/1 $status_code OK");
        echo json_encode($data);
    }
}