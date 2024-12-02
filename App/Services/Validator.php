<?php

namespace App\Services;

class Validator
{
    public function is_valid_province($province_id): bool
    {

//        if ( is_numeric($province_id)) {
//
//            global $pdo;
//            $sql = "select * from city where province_id=:province_id";
//            $stmt = $pdo->prepare($sql);
//            $stmt->execute([':province_id' => $province_id]);
//            $result = $stmt->fetch();
//            var_dump($province_id);
//            return (bool)$result;
//
//        } else {
//            return false;
//        }

        if (is_numeric($province_id)) {

            global $pdo;
            $sql = "select * from province where id=:province_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':province_id' => $province_id]);
            $result = $stmt->fetch();
            return (bool)$result;

        } else {
            return false;
        }


    }

    public function is_valid_city($city_id): bool
    {
        global $pdo;
        $sql = "select * from city where id=:city_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':city_id' => $city_id]);
        $result = $stmt->fetch();
        var_dump($stmt);
        return (bool)$result;

    }

    public function is_valid_name($name): bool
    {
        if (is_string($name) && strlen($name) > 3) {

            return true;
        } else {


            return false;
        }
    }

    public function is_valid_pagination($page, $page_size)
    {

        if (isset($page) && isset($page_size) and
            !empty($page) &&!empty($page_size)) {


            if (is_numeric($page) && $page > 0 and
                is_numeric($page_size) && $page_size > 0) {

                return true;
            }  else {

                return false;
            }
        }elseif ($page == null && $page_size == null) {

            return true;
        }
    }

    public function cityGetRequestValidation($data)
    {

        $province_id = $data['province_id'] ?? null;
        $page = $data['page'] ?? null;
        $page_size = $data['page_size'] ?? null;


        if (!empty($data)) {

            if (isset($province_id) or !empty($province_id)) {

                if ($this->is_valid_province($province_id)) {

                    return $this->is_valid_pagination($page, $page_size);
                } else {
                    return false;
                }
            } else {

                return $this->is_valid_pagination($page, $page_size);
            }

        } else {

            return true;
        }

    }

    public function cityPostRequestValidation($data)
    {
        if (!empty($data)) {
            $province_id = $data['province_id'];
            $name = $data['name'];
        } else {
            return false;
        }
        if (isset($province_id) && !empty($province_id)) {
            if ($this->is_valid_province($province_id)) {

                return $this->is_valid_name($name);
            };
        } else {
            return false;
        }
    }

    public function cityPutRequestValidation($data)
    {
        if (!empty($data)) {
            $city_id = $data['city_id'];
            $name = $data['name'];
        } else {
            return false;
        }
        if (isset($city_id) && !empty($city_id)) {
            if ($this->is_valid_city($city_id)) {

                return $this->is_valid_name($name);
            };
        } else {
            return false;
        }
    }

    public function cityDeleteRequestValidation($city_id)
    {

        if ($city_id != null) {

            if (is_numeric($city_id)) {

                if ($this->is_valid_city($city_id)) {

                    return true;
                };
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function provincePostRequestValidation($name)
    {
        if (!empty($name)) {
            return $this->is_valid_name($name);
        }
    }

    public function provincePutRequestValidation($data)
    {
        if (!$data == null) {
            $province_id = $data['province_id'];
            $name = $data['name'];
            if (is_numeric($data['province_id'])) {
                if ($this->is_valid_province($province_id)) {
                    if (!empty($name)) {
                        return $this->is_valid_name($name);
                    } else {
                        return false;
                    }

                };
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function provinceDeleteRequestValidation($province_id)
    {

        if ($province_id != null) {

            if (is_numeric($province_id)) {

                if ($this->is_valid_province($province_id)) {

                    return true;
                };
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}