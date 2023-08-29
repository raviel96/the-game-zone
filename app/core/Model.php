<?php
namespace app\core;

abstract class Model {

    public const RULE_REQUIRED = "required";
    public const RULE_USERNAME = "username";
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MATCH = "match";
    public const RULE_UNIQUE = "unique";

    public array $errors = [];

    public function loadData($data) {
        foreach ($data as $key => $value) {
            if(property_exists($this, $key)) {
                if(is_string($value) && strlen($value) == 0) {
                    $value = "Non spécifié";       
                }

                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules();

    public function labels(): array {
        return [];
    }

    public function getLabel($attribute) {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function validate() {
        foreach($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            
            foreach($rules as $rule) {
                $ruleName = $rule;

                if(is_array($rule)) {
                    $ruleName = $rule[0];
                }

                switch($ruleName) {
                    case ($ruleName === self::RULE_REQUIRED && !$value) : 
                        $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                        break;
                    case ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) : 
                        $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                        break;
                    case ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) :
                        $rule['match'] = $this->getLabel($rule['match']); 
                        $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                        break;
                    case ($ruleName === self::RULE_UNIQUE): {
                            $className = $rule['class'];
                            $uniqueAttr = $rule['attribute'] ?? $attribute;
                            $tableName = $className::tableName();

                            $sql = "SELECT * FROM $tableName WHERE $uniqueAttr = :attr";
                            
                            $statement = Application::$app->getDatabase()->prepare($sql);
                            $statement->bindValue(":attr", $value);
                            $statement->execute();

                            $record = $statement->fetchObject();
                            if($record) $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                        }
                        break;
                    case ($ruleName == self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)):
                            $this->addErrorForRule($attribute, self::RULE_EMAIL);
                            break; 
                    default:
                        break;
                }

            }
        }

        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $params = []) {
        $message = $this->errorMessages()[$rule] ?? '';
        
        foreach($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $messages) {
        $this->errors[$attribute][] = $messages;
    }

    public function errorMessages() {
        return [
            self::RULE_REQUIRED => 'Champ obligatoire',
            self::RULE_MIN => 'Ce champ doit contenir au moins {min} caractères',
            self::RULE_MATCH => 'Ce champ doit être identique au champ "{match}"',
            self::RULE_UNIQUE => 'Cet {field} existe déjà',
            self::RULE_EMAIL => 'Veuillez saisir une adresse e-mail valide'
        ];
    }

    public function hasErrors($attribute) {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute) {
        return $this->errors[$attribute][0] ?? false;
    }
}