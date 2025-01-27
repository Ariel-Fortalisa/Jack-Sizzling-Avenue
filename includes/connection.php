<?php

    function db() {
        static $conn;
        if ($conn===NULL){ 
            $conn = new mysqli('localhost', 'root', '', 'jacksizzling');
        }
        return $conn;
    }

    $conn = db();
?>