<?php

namespace app\models;
use app\core\GameModel;

class Game extends GameModel {

    public string $title;
    public string $description;
    public string $cover;
    public int $id;


    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function tableName(): string {
        return "game";
    }

    public function primaryKey():string {
        return "id"; 
    }

    public function attributes():array {
        $attributes = ['title', "description"];

        return $attributes;
    }

    public function rules() :array {
        return [];
    }
}