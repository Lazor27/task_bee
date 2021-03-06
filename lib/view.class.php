<?php

class View {
    protected $data;
    protected $path;

    public function __construct($data = array() , $path = 0)
    {
        if (!$path) {

            $path = self::getDefaultViewPath();
        }
        if (!file_exists($path)) {
            throw new Exception('Template file is not found in path: ' . $path);
        }

        $this->data = $data;
        $this->path = $path;
    }

    protected static function getDefaultViewPath()
    {
        $router = App::getRouter();

        if (!$router) {
            return false;
        }

        $controller_name_dir = $router->getController();
        $template_name = $router->getMethodPrefix().$router->getAction().'.html';
        return VIEWS_PATH.DS.$controller_name_dir.DS.$template_name;
    }

  
    public function render(){
        $data = $this->data;

        ob_start();
        include($this->path);
        
        $content = ob_get_clean();
        return $content;
    }
}