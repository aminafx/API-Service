<?php

namespace App\Services;

class ProvinceService
{

    function getProvinces($data = null)
    {

        return getProvinces($data);
    }

    public function createProvince($data)
    {
        return addProvince($data);
    }

    public function updateProvince($province_id, $name)
    {
        return changeProvinceName($province_id, $name);
    }

    public function deleteProvince($province_id)
    {
        return deleteProvince($province_id);
    }

}