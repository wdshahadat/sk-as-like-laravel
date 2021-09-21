<?php

namespace App\Http\Services;

use App\Http\Services\Db;
use App\Traits\QueryBuilderTrait;

abstract class QueryBuilder extends Db
{
    use QueryBuilderTrait;

    public $store = [];
    private static $calledMethodAsProperty = [];

    private static $calledModal;
    private static $tableName;
    private static $selectColumn = '*';
    private static $recentlyAddedAttr;
    private static $withMethods = [];


    // for relation eloquent
    private $local_key;
    private $foreign_key;
    private $relationModal;
    private $calledMethodName;


    private static function cModal()
    {
        if (self::$calledModal && get_called_class() === get_class(self::$calledModal)) {
            return self::$calledModal;
        } else {
            self::$calledModal = new static();
            return self::$calledModal;
        }
    }

    public static function data()
    {
        return self::$dataStore;
    }

    private function getRecentlyAddedAttr()
    {
        if (!self::$recentlyAddedAttr) {
            self::$recentlyAddedAttr = $this->store;
            //                array_diff(
            //                    get_object_vars($this),
            //                    get_object_vars(new static())
            //                );
        }
        return self::$recentlyAddedAttr;
    }

    private static function getTable($modal = false)
    {
        $calledModal = $modal ? $modal : get_called_class();
        if (property_exists($calledModal, 'table')) {
            return get_class_vars($calledModal)['table'];
        }
        $tableName = '';
        foreach (str_split(basename($calledModal)) as $index => $letter) {
            $tableName .= preg_match('/[A-Z]/', $letter, $matches) ?
                ($index > 0 ? '_' : '' . strtolower($letter)) : $letter;
        }
        $tableName .= strpos($tableName, '_') ? '' : 's';
        return $tableName;
    }

    private function arrayToInsertSql($values)
    {
        $table = self::getTable();
        $keys = implode('`, `', array_keys($values));
        $valueData = implode("', '", $values);
        return "INSERT INTO `{$table}` (`{$keys}`) VALUES ('{$valueData}')";
    }

    public function save()
    {
        return $this->create($this->getRecentlyAddedAttr());
    }

    public function create($createData)
    {
        $sql = $this->arrayToInsertSql($createData);
        return self::connect()->query($sql) ? self::last('', 1) : false;
    }

    public function update($updateData = false)
    {
        $table = self::getTable();
        $updateData = $updateData ? $updateData:$this->getRecentlyAddedAttr();
        $update = implode(', ', array_map(function ($key, $value) {
            return "{$key} = '{$value}'";
        }, array_keys($updateData), array_values($updateData)));
        $whereCondition = self::$whereFilter;

        $sql = "UPDATE {$table} SET {$update} {$whereCondition}";
        return self::connect()->query($sql) ? self::find($whereCondition)->data() : false;
    }


    //select part
    public static function table($table = false)
    {
        if ($table) {
            self::$tableName = $table;
        }
        return new static();
    }
    public static function select($selectColumn = '*')
    {
        self::$selectColumn = $selectColumn;
        return new static();
    }

    private static function whereProses(array $data)
    {
        if (is_array($data)) {
            $count = 0;
            $whereCondition = '';
            foreach ($data as $key => $value) {
                $count++;
                $and = count($data) > $count ? 'AND ' : '';
                $whereCondition .= "`{$key}`='$value' {$and}";
            }
        } elseif (is_string($data)) {
            $whereCondition = $data;
        }
        return empty($whereCondition) ? '' : $whereCondition;
    }

    public static function where($data, $onlyWhere = false)
    {
        $whereCondition = self::whereProses($data);
        if (self::$whereFilter && strpos(self::$whereFilter, 'WHERE')) {
            self::$whereFilter .= " AND {$whereCondition}";
        } else {
            self::$whereFilter = " WHERE {$whereCondition}";
        }
        return $onlyWhere ? self::$whereFilter : new static();
    }

    public static function whereIn(string $column, $whereInCondition, $onlyWhere = false)
    {
        $whereInCondition = is_string($whereInCondition) ? $whereInCondition : implode(', ', $whereInCondition);
        if (self::$whereFilter && strpos(self::$whereFilter, 'WHERE')) {
            self::$whereFilter .= " AND {$column} IN ({$whereInCondition})";
        } else {
            self::$whereFilter = " WHERE {$column} IN ({$whereInCondition})";
        }
        return $onlyWhere ? $whereInCondition : new static();
    }

    public static function destroy($id)
    {
        $table = self::getTable();
        $whereCondition = is_numeric($id) ? "id={$id}" : $id;
        $sql = "DELETE FROM {$table} WHERE {$whereCondition}";
        return self::connect()->query($sql);
    }

    public static function find($condition)
    {
        $current = new static();
        return $current->first($condition);
    }

    public function first($condition = false, $table = false)
    {
        if (!$condition) {
            return new static();
        } elseif (is_numeric($condition)) {
            $condition = "id={$condition}";
        }
        return self::last($condition, 1, $table);
    }

    public static function last($condition = false, $onlyData = false, $table = false)
    {
        $table = $table ? $table : self::getTable();
        if (is_array($condition)) {
            $condition = self::where($condition, 1);
        } elseif ($condition && !empty($condition)) {
            $condition = strpos($condition, 'WHERE') ? $condition : " WHERE {$condition}";
        }

        $sql = "SELECT * FROM `{$table}`{$condition} ORDER BY id DESC LIMIT 1";
        $data = self::dataService(self::connect()->query($sql));
        self::$dataStore = $data;

        $objectData = array_shift($data);
        $currentModal = new static();
        foreach ($objectData as $key => $val) {
            $currentModal->{$key} = $val;
        }
        return $currentModal;
//        return $onlyData ? $objectData : $currentModal;
    }

    public static function all()
    {
        $table = self::getTable();
        $data = self::dataService(self::connect()->query("SELECT * FROM `{$table}`"));

        return new static();
    }
    public function get()
    {
        $table = self::getTable();
        $join = self::$joinCondition;
        $whereCondition = self::$whereFilter;
        $columnsSelect = self::$selectColumn;
        $localId = empty($join) ? '' : ", {$table}.id as id";

        $sql = "SELECT {$columnsSelect}{$localId} FROM `{$table}` {$join} {$whereCondition}";
        self::dataService(self::connect()->query($sql));

        if (!empty(self::$withMethods)) {
            foreach (self::$withMethods as $method) {
                call_user_func([$this, $method]);
            }
        }
        return $this;
    }

    public static function join($type, $joinTable, $joinRelation)
    {
        $type = strtoupper($type);
        self::$joinCondition .= "{$type} JOIN {$joinTable} ON {$joinRelation}";
        return new static();
    }


    // eloquent relation
    private function relationTable($modalObject)
    {
        $cls = $modalObject;
        $modelVars = get_class_vars($cls);
        if (in_array('table', array_keys($modelVars))) {
            return $modelVars['table'];
        } else {
            $tableName = '';
            foreach (str_split(basename($cls)) as $index => $letter) {
                $tableName .= preg_match('/[A-Z]/', $letter, $matches) ? ($index > 0 ? '_' : '' . strtolower($letter)) : $letter;
            }
            $tableName .= strpos($tableName, '_') ? '' : 's';
            return $tableName;
        }
    }

    public static function with($methodNames = [])
    {
        self::$withMethods = is_string($methodNames) ? [$methodNames] : $methodNames;

        $calledModal = new static();
        if (!empty(self::$dataStore)) {
            foreach (self::$withMethods as $method) {
                call_user_func([$calledModal, $method]);
            }
            self::$withMethods = [];
        }
        return $calledModal;
    }

    private function setRelationInfo($modal, $foreign_key, $local_key, $hasOne)
    {
        $this->relationModal = $modal;
        $this->local_key = $local_key;
        $this->calledMethodName = $hasOne ? $hasOne : debug_backtrace()[1]['function'];
        $this->foreign_key = $foreign_key ? $foreign_key : strtolower(basename(static::class)) . '_id';
        return $this;
    }

    private function getMany($table, $condition = false)
    {
        $condition = $condition ? $condition : self::$whereFilter;
        $sql = "SELECT * FROM `{$table}`{$condition}";
        return self::dataService(self::connect()->query($sql), false, false);
    }

    public function hasOne($modal, $foreign_key = false, $local_key = 'id')
    {
        return $this->hasMany($modal, $foreign_key, $local_key, debug_backtrace()[1]['function']);
    }

    public function hasMany($modal, $foreign_key = false, $local_key = 'id', $hasOne = false)
    {
        $this->setRelationInfo($modal, $foreign_key, $local_key, $hasOne ? $hasOne : debug_backtrace()[1]['function']);

        $dataStore = self::$dataStore;
        $first = array_shift($dataStore);

        if ($first && is_object($first)) {
            self::whereIn($this->local_key, array_column(self::$dataStore, $this->local_key));
            $relationData = $this->getMany(self::getTable($this->relationModal));

            self::$dataStore = array_map(function ($item) use ($relationData, $hasOne) {
                $relation_data = $relationData ? array_filter($relationData, function ($r_item) use ($item) {
                    $owner_key_value = $item->{$this->local_key};
                    $foreign_key_value = $r_item->{$this->foreign_key};

                    return $owner_key_value === $foreign_key_value && $foreign_key_value !== null;
                }) : [];
                $item->{$this->calledMethodName} = $hasOne ? array_shift($relation_data) : $relation_data;
                return $item;
            }, self::$dataStore);

            if ($hasOne && isset(self::$calledMethodAsProperty["{$hasOne}property"])) {
                $data = array_shift(self::$dataStore);
                return $data->{$hasOne};
            }
            return self::$dataStore;
        }
        return $hasOne ? null : [];
    }

    public function belongsTo($modal, $foreign_key = false, $local_key = 'id')
    {
        return $this->belongsToMany($modal, $foreign_key, $local_key, debug_backtrace()[1]['function']);
    }

    public function belongsToMany($modal, $foreign_key = false, $local_key = 'id', $belongsTo = false)
    {
        $foreign_key = $foreign_key ? $foreign_key : strtolower(basename($modal)) . '_id';
        $this->setRelationInfo($modal, $foreign_key, $local_key, $belongsTo ? $belongsTo : debug_backtrace()[1]['function']);

        $dataStore = self::$dataStore;
        $first = array_shift($dataStore);

        if ($first && is_object($first)) {
            self::whereIn($this->local_key, array_column(self::$dataStore, $this->foreign_key));
            $relationData = $this->getMany(self::getTable($this->relationModal));

            self::$dataStore = array_map(function ($item) use ($relationData, $belongsTo) {
                $relation_data = $relationData ? array_filter($relationData, function ($r_item) use ($item) {
                    $owner_key_value = $item->{$this->foreign_key};
                    $foreign_key_value = $r_item->{$this->local_key};

                    return $owner_key_value === $foreign_key_value && $foreign_key_value !== null;
                }) : [];

                $item->{$this->calledMethodName} = $belongsTo ? array_shift($relation_data) : $relation_data;
                return $item;
            }, self::$dataStore);
            if ($belongsTo && isset(self::$calledMethodAsProperty["{$belongsTo}property"])) {
                $data = array_shift(self::$dataStore);
                return $data->{$belongsTo};
            }
            return self::$dataStore;
        }
        return $belongsTo ? null : [];
    }

    public function __set($name, $value)
    {
        $this->store[$name] = $value;
    }

    public function __get($name)
    {
        $calledModal = get_called_class();
        if (array_key_exists($name, $this->store)) {
            return $this->store[$name];
        } elseif (method_exists($calledModal, $name)) {
            $cl =  new \ReflectionMethod($calledModal, $name);
            $calledModal = $cl->isStatic() ? $calledModal : new $calledModal;
            self::$calledMethodAsProperty["{$name}property"] = true;
            return call_user_func([$calledModal, $name]);
        }
        return null;
    }
}
