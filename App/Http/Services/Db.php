<?php

namespace App\Http\Services;

use \PDO;

class Db
{
    private $db;
    private static $instance;
    protected static $whereFilter;
    protected static $joinCondition = '';
    protected static $dataStore = [];
    private $dbUser = 'root';
    private $dbPass = '';
    private $dbName = 'mysql:host=localhost;dbname=phpoop';

    public function __construct()
    {
        $this->db = new \PDO($this->dbName, $this->dbUser, $this->dbPass);
        self::$instance = $this->db;
    }

    public static function connect()
    {
        random_int(2, 50);
        if (!self::$instance) {
            $instance = new self();
            self::$instance = $instance->db;
        }
        return self::$instance;
    }

    private static function rowProses($row)
    {
        if (is_array($row)) {
            foreach ($row as $k => $v) {
                $row[$k] = is_numeric($v) ? intval($v) : $v;
            }
        } else {
            foreach ($row as $k => $v) {
                $row->{$k} = is_numeric($v) ? intval($v) : $v;
            }
        }
        return $row;
    }

    protected static function dataService($result, $dataTypeArray = false, $storeData = true): ?array
    {
        if (isset($result) && !is_bool($result)) {
            $dataStore = [];
            self::$whereFilter = false;
            self::$joinCondition = '';

            $returnType = $dataTypeArray ? PDO::FETCH_ASSOC: PDO::FETCH_OBJ;

            while ($row = $result->fetch($returnType)) {
                $dataStore[] = self::rowProses($row);
            }
            if ($storeData) {
                self::$dataStore = $dataStore;
            }
            return empty($dataStore) ? null:$dataStore;
        }
        return null;
    }
}
