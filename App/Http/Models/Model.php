<?php

namespace App\Http\Models;

use App\Config\QueryBuilder;

class Model extends QueryBuilder
{
    private static $model;
    public static $tableName;
    public static $inserted;

    public function __construct()
    {
        $tableName = strtolower(basename(get_called_class()));
        if ($tableName !== 'model') {
            self::$tableName = $tableName . 's';
        }
        self::$model = $this;
    }

    private static function staticQuery()
    {
        if (!static::$model) {
            self::$model = new static;
        }
        return self::$model;
    }

    public static function table($table = '')
    {
        self::$tableName = $table;
        return self::staticQuery();
    }

    public function store($storeData)
    {
        return self::create($storeData);
    }

    public function first()
    {
        $data = $this->data();
        if (is_array($data)) {
            return $data[0];
        } elseif (self::$whereFilter) {
            return self::getFirst(" WHERE " . self::$whereFilter)->data();
        }
    }
}
