<?php

namespace app\core;

class View {

    private string $title = "";
    
    public function renderView($view, $params = []) {

        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function layoutContent() {

        $layout = Application::$app->layout;
        
        if(Application::$app->getController()) {
            $layout = Application::$app->getController()->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    public function renderOnlyView($view, $params) {
        extract($params);
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

	public function getTitle(): string {
		return $this->title;
	}
	
	public function setTitle(string $title) {
		$this->title = $title;
	}
}