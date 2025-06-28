<?php
    function get_environment_variable($point){
        if (!file_exists(ENV_PATH)) {
            throw new Exception('Environment file not found: ' . ENV_PATH);
        }

        $niz = file(ENV_PATH, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $target = null;
        foreach($niz as $n){
            $n = trim($n);
            list($id, $value) = explode("=", $n, 2);
            if($id == $point){
                $target = $value;
                break;
            }
        }
        return $target;
    }
    define("ENV_PATH", __DIR__ . "/.env");  
    define("SERVER", get_environment_variable("SERVER"));
    define("DATABASE", get_environment_variable("DATABASE"));
    define("USERNAME", get_environment_variable("USERNAME"));
    define("PASSWORD", get_environment_variable("PASSWORD"));
?>