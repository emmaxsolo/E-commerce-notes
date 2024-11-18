<?php

class Controller {

    function route() {
    }

    function render($controller, $view, $data = []) {
        if (!is_string($controller) || !is_string($view)) {
            throw new Exception("Controller and view names must be strings.");
        }

        extract($data);

        $viewFile = "Views/$controller/$view.php";

        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "View file '$viewFile' not found.";
        }
    }
}

?>
