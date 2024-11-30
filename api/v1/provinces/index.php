<?php
include "../../../autoloader.php";
use App\Utilities\Response;
use App\Services\ProvinceService;
$request_method = $_SERVER['REQUEST_METHOD'];
if( $request_method=='GET'){




    $result = getProvinces();
    Response::respondAndDie($result,Response::HTTP_OK);
}
elseif( $request_method=='POST'){
    $result =(array) json_decode(file_get_contents('php://input'));
    addProvince($result);
    Response::respondAndDie($result);
}
elseif( $request_method=='PUT'){

    $result  = json_decode(file_get_contents("php://input"),true);
    $province_id = $result['province_id'];
    $name = $result['name'];
    changeProvinceName($province_id,$name);
    Response::respondAndDie($result);
}
elseif( $request_method=='DELETE'){
    $result  = json_decode(file_get_contents("php://input"),true);
    $province_id = $result['province_id'];
    deleteProvince($province_id);
    Response::respondAndDie($result);

}else{
    Response::respondAndDie(["Invalid Request Method"],405);
}

