<?php

namespace app\core;

abstract class UserModel extends DatabaseModel {
    abstract public function getName(): string;
}