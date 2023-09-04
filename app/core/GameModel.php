<?php

namespace app\core;

abstract class GameModel extends DatabaseModel {

    abstract public function getTitle();
    abstract public function getDescription();
}