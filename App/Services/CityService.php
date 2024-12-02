<?php

namespace App\Services;

class CityService
{

    public function getCities($data = null)
    {

        return getCities($data);
    }

    public function createCity($data)
    {
        return addCity($data);
    }

    public function updateCity($city_id, $name)
    {
        return changeCityName($city_id, $name);

    }

    public function deleteCity($city_id)
    {
        return deleteCity($city_id);

    }

}