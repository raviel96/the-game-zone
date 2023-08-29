<?php
namespace app\core;
class Request {

    public function getPath() {
        // Si REQUEST_URI n'est pas présent, alors le path sera la page d'accueil
        $path = $_SERVER['REQUEST_URI'] ?? "/";

        // On prend la position du ?. Si la position est nulle, on retourne le path
        $position = strpos($path, "?");
        if(!$position) {
            return $path;
        }
        
        // Si on trouve un ?, alors on récupère uniquement ce qui se trouve avant pour avoir le chemin correct
        return substr($path, 0, $position);
    }
    public function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getData() {
        $data = [];

        if($this->getMethod() == "get") {
            foreach($_GET as $key => $value) {
                $data[$key] = html_entity_decode(filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS));
            }
        }
        if($this->getMethod() == "post") {
            foreach($_POST as $key => $value) {
                $data[$key] = html_entity_decode(filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS));
            }
        }

        return $data;
    }

    public function isGet() {
        return $this->getMethod() == "get";
    }
    public function isPost() {
        return $this->getMethod() == "post";
    }
}