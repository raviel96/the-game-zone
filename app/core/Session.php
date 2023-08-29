<?php

namespace app\core;

class Session {

    protected const FLASH_KEY = "flash_messages";

    public function __construct() {
        session_start();

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flashMessages as $key => &$flasMessage) {
            $flasMessage['remove'] = true;
        }

        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function get($key) {
        return $_SESSION[$key] ?? false;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function remove($key) {
        unset($_SESSION[$key]);
    }

    public function setFlash($key, $message) {
        $_SESSION[self::FLASH_KEY][$key] = [
            "remove" => false,
            "value" => $message
        ];
    }

    public function getFlash($key) {
        return $_SESSION[self::FLASH_KEY][$key] ?? false;
    }

    public function getFlashMessage($key) {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct() {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach($flashMessages as $key => &$flasMessage) {
            if($flasMessage['remove']) unset($flashMessages[$key]);
        }
        
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}