<?php
include "../../../autoloader.php";
use App\Utilities\Response;
use App\Services\CityService;
$request_method = $_SERVER['REQUEST_METHOD'];
if( $request_method=='GET'){
    $province_id = $_GET['province_id']??null;

    $request_data = ['province_id'=>$province_id];

    $result = getCities($request_data);
    Response::respondAndDie($result,Response::HTTP_OK);
}
elseif( $request_method=='POST'){
   $result =(array) json_decode(file_get_contents('php://input'));
   addCity($result);
   Response::respondAndDie($result);
}
elseif( $request_method=='PUT'){

    $result  = json_decode(file_get_contents("php://input"),true);
    $city_id = $result['city_id'];
    $name = $result['name'];
    changeCityName($city_id,$name);
    Response::respondAndDie($result);
}
elseif( $request_method=='DELETE'){
    $result  = json_decode(file_get_contents("php://input"),true);
    $city_id = $result['city_id'];
    deleteCity($city_id);
    Response::respondAndDie($result);
}else{
    Response::respondAndDie(["Invalid Request Method"],405);
}

