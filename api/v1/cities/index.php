<?php
include "../../../autoloader.php";
use App\Utilities\Response;
use App\Services\CityService;
$city  =new CityService();
$reslut =(object) $city->getCities();
Response::respond($reslut,200);