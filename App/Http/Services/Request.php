<?php

namespace App\Http\Services;

class Request
{

    public static string $pageTitle = 'PHP (OOP) Custom MVC';
    public static $requestData = [];
    private static $urlParams = [];
    private static $sessionKey;

    public function all()
    {
        return self::$requestData;
    }

    public function urlParams($urlParams = false)
    {
        if ($urlParams) {
            self::$urlParams = $urlParams;
        }
        return self::$urlParams;
    }

    // Session set manage
    public static function session($key = false, $val = false)
    {

        if (is_array($key) || is_object($key)) {
            $session = (array) $key;
        } elseif (isset($val) && (is_array($val) || is_object($val))) {
            $session = (array) $key;
        }

        if ($key && $val && (is_string($key) && is_string($val))) {
            $session = [$key => $val];
        }

        if (isset($session) && is_array($session)) {
            $sessionKey = self::$sessionKey ? self::$sessionKey : 'error';
            $_SESSION[$sessionKey] = $session;
        }
    }


    // input value filter start
    public function fieldValidation($val, $null_check)
    {
        if (is_array($val)) {
            return $this->validation($val, $null_check);
        }
        $data = trim($val);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        $data = trim($data);
        if (isset($null_check)) {
            $data = isset($data) ? $data : '';
        }
        return $data;
    }

    public function validation($data_, $null_check = null, $remove = null)
    {
        if (is_array($data_)) {
            $dataArray = array();
            foreach ($data_ as $key => $value) {
                if (is_array($value)) {
                    if (!empty($value)) {
                        $sub_value_array = [];
                        foreach ($value as $sub_key => $array_value) {
                            $sub_value_array[$sub_key] = $this->fieldValidation($array_value, $null_check);
                        }
                        $dataArray[$key] = $sub_value_array;
                    }
                    $dataArray[$key] = $value;
                } else {
                    $value = $this->fieldValidation($value, $null_check);
                    if (isset($remove) && !empty($value)) {
                        $dataArray[$key] = $value;
                    } elseif (!isset($remove)) {
                        $dataArray[$key] = $value;
                    }
                }
            }
            return $dataArray;
        } elseif (!empty($data_)) {
            return $this->fieldValidation($data_, $null_check);
        }
        return $data_;
    } // input value filter end
    // input value verification
    public function valueFilter($val)
    {
        $data = trim($val);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function validator($data_)
    {
        if (is_array($data_)) {
            $dataArray = [];
            foreach ($data_ as $key => $value) {
                $dataArray[$key] = $this->valueFilter($value);
            }
            return $dataArray;
        } else {
            return $this->valueFilter($data_);
        }
    } // end verification
}
