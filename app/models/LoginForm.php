<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginForm extends Model {

    public string $username= "";
    public string $password = "";

    public function rules():array {
        return [
            'username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function labels():array {
        return [
            'username' => "Identifiant",
            'password' => "Mot de passe"
        ];
    }

    public function login() {
        $user = (new User)->findOne(['username' => $this->username]);

        if(!$user) {
            $this->addError('username', "Cet identifiant n'existe pas.");
            return false;
        }

        if(!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Mot de passe incorrect.');
            return false;
        }
        
        return Application::$app->login($user);
    }
    

	
	public function getUsername(): string {
		return $this->username;
	}
	
	public function setUsername(string $username) {
		$this->username = $username;
	}
	
	public function getPassword(): string {
		return $this->password;
	}
	
	public function setPassword(string $password) {
		$this->password = $password;
	}
}