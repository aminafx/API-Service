<?php
include "../../../autoloader.php";
use App\Utilities\Response;
use App\Services\ProvinceService;
use App\Services\Validator;
use App\Utilities\CacheUtility;

$request_method = $_SERVER['REQUEST_METHOD'];

# GET METHOD
if( $request_method=='GET'){
    CacheUtility::start();
    $page = $_GET['page'] ?? null;
    $page_size = $_GET['page_size'] ?? null;
    $validate= new Validator();
     if(!$validate->is_valid_pagination($page,$page_size)){
         Response::respondAndDie("Pagination Gone Wrong", Response::HTTP_NOT_FOUND);

     };
    $province_service = new ProvinceService();
    $request_data = [
        'page'=>$page,
        'page_size'=>$page_size,
    ];
    $result = $province_service->getProvinces($request_data);
    echo Response::respond($result,Response::HTTP_OK);
    CacheUtility::end();

}


# POST METHOD
elseif( $request_method=='POST'){
    $result =(array) json_decode(file_get_contents('php://input'));
    $validate = new Validator();
    if(!$validate->provincePostRequestValidation($result['name'])){
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
    if(!$validate->provincePutRequestValidation($result)){
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

