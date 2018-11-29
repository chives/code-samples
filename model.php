<?php

class model {
    public function __get($model) {
        
        $config = registry::register("config");
        $router = registry::register("router");

        $_model = $model.'model';
        $controller = $router->getController();
        $modelfile = $config->model_path."/".$controller."/".$_model.".php";

        if(!file_exists($modelfile)) {
            $modelfile = "core/models/nullmodel.php";
            $_model = "nullmodel";
        }

        include_once($modelfile);

        $modelobj = registry::register($_model);

        return $modelobj;
    }
}

?>