<?php

namespace app\core;

abstract class DatabaseModel extends Model {
    
    abstract public function tableName() :string;
    abstract public function attributes() :array;
    abstract public function primaryKey() :string;

    
    public function insert() {
        $tableName = $this->tableName();
        $attributes = $this->attributes();

        $params = array_map(fn($attr) => ":$attr", $attributes);

        $sql = "INSERT INTO $tableName (".implode(",", $attributes).")
                VALUES (".implode(",", $params).")";

        $statement = self::prepare($sql);
        
        foreach($attributes as $attribute) {
            $statement->bindParam(":$attribute", $this->{$attribute});
        }
        
        $statement->execute();

        return true;
    }

    public function findOne($where) {
        $tableName = static::tableName();

        $attributes = array_keys($where);
        $sql = implode("AND",array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

        foreach($where as $key => $value) {
            $statement->bindParam(":$key", $value);
        }

        $statement->execute();

        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql) {
      return  Application::$app->getDatabase()->pdo->prepare($sql);
    }

}