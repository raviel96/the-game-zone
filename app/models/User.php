<?php
namespace app\models;

use app\core\DatabaseModel;
use app\core\UserModel;

class User extends UserModel {
    
    public string $username = "";
    public string $password = "";
    public string $passwordConfirm = "";
    public string $createdAt;
    public int $id;

    public function tableName(): string {
        return "user";
    }

    public function primaryKey():string {
        return "id"; 
    }

    public function save() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return $this->insert();
    }

    public function rules() :array {
        $rules = [
            "username" => [self::RULE_REQUIRED, [self::RULE_UNIQUE, "class" => self::class]],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 6]],
            "passwordConfirm" => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];

        return $rules;
    }

    public function attributes():array {
        $attributes = ['username', "password"];

        return $attributes;
    }

    public function labels(): array {
        $labels = [
            "username" => "Identifiant",    
            "password" => "Mot de passe",    
            "passwordConfirm" => "Confirmer le mot de passe"    
        ];
        
        return $labels;
    }

    public function getName(): string {
        return $this->username;
    }
}