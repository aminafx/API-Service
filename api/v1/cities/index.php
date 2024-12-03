<?php
include "../../../autoloader.php";

use App\Utilities\Response;
use App\Services\CityService;
use App\Services\Validator;
use App\Utilities\CacheUtility;

$request_method = $_SERVER['REQUEST_METHOD'];

# GET METHOD
if ($request_method == 'GET') {

    CacheUtility::start();
    $province_id = $_GET['province_id'] ?? null;
    $page = $_GET['page'] ?? null;
    $page_size = $_GET['page_size'] ?? null;
    $validate = new Validator();
        if (!$validate->cityGetRequestValidation($_GET)) {
            Response::respondAndDie("Request Gone Wrong", Response::HTTP_NOT_FOUND);
        }
    $request_data = [
        'province_id' => $province_id,
        'page'=>$page,
        'page_size'=>$page_size,
    ];
    $city_service = new CityService();
    $result = $city_service->getCities($request_data);
   echo Response::respond($result, Response::HTTP_OK);

    CacheUtility::end();
# POST METHOD
} elseif ($request_method == 'POST') {
    $data = (array)json_decode(file_get_contents('php://input'));
    $validate = new Validator();


    if (!$validate->cityPostRequestValidation($data)) {
        Response::respondAndDie("Request Is Not Valid", Response::HTTP_BAD_REQUEST);

    };

    $city_service = new CityService();
    $response = $city_service->createCity($data);
    Response::respondAndDie($data);

#PUT METHOD
} elseif ($request_method == 'PUT') {

    $result = json_decode(file_get_contents("php://input"), true);
    $city_id = $result['city_id'];
    $name = $result['name'];

    $validate = new Validator();
    if (!$validate->cityPutRequestValidation($result)) {
        Response::respondAndDie("City Not Found", Response::HTTP_NOT_FOUND);

    };

    $city_service = new CityService();
    $response = $city_service->updateCity($city_id, $name);
    Response::respondAndDie($result);

#DELETE METHOD
} elseif ($request_method == 'DELETE') {



    $validate = new Validator();
    if (!$validate->cityDeleteRequestValidation( $_GET['city_id'])) {
        Response::respondAndDie("City Not Found", Response::HTTP_NOT_FOUND);
    };
    $city_id = $_GET['city_id'];
    $city_service = new CityService();
    $response = $city_service->deleteCity($city_id);
    Response::respondAndDie($city_id);


} else {
    Response::respondAndDie(["Invalid Request Method"], 405);
}

