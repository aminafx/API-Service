<?php
include "../../../autoloader.php";
use App\Utilities\Response;
use App\Services\ProvinceService;
use App\Services\Validator;
$request_method = $_SERVER['REQUEST_METHOD'];

# GET METHOD
if( $request_method=='GET'){
    $province_service = new ProvinceService();
    $result = $province_service->getProvinces();
    Response::respondAndDie($result,Response::HTTP_OK);
}


# POST METHOD
elseif( $request_method=='POST'){
    $result =(array) json_decode(file_get_contents('php://input'));
    $validate = new Validator();
    if(!$validate->ProvincePostRequestValidation($result['name'])){
        Response::respondAndDie("Name Is Not Valid", Response::HTTP_NOT_FOUND);
    }
    $province_service = new ProvinceService();
    $response = $province_service->createProvince($result);

    Response::respondAndDie($result);
}


# PUT METHOD
elseif( $request_method=='PUT'){

    $result  = json_decode(file_get_contents("php://input"),true);
    $validate = new Validator();
    if(!$validate->ProvincePutRequestValidation($result)){
        Response::respondAndDie("Province Not Found", Response::HTTP_NOT_FOUND);

    };

    $province_id = $result['province_id'];
    $name = $result['name'];
    $province_service = new ProvinceService();
    $response = $province_service->updateProvince($province_id,$name);
    Response::respondAndDie($result);
}


#DELETE METHOD
elseif( $request_method=='DELETE'){

    $validate = new Validator();
    if(!$validate->provinceDeleteRequestValidation($_GET['province_id'])){
        Response::respondAndDie("Province Not Found", Response::HTTP_NOT_FOUND);

    };
    $province_id = $_GET['province_id'];
    $province_service = new ProvinceService();
    $response = $province_service->deleteProvince($province_id);
    Response::respondAndDie($province_id);

}else{
    Response::respondAndDie(["Invalid Request Method"],405);
}

