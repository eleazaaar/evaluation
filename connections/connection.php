<?php
    function connection() {
        // $host = "localhost";
        // $username = "jckkniva_bscs3b";
        // $password = "JW?zx5=SZZ95";
        // $database = "jckkniva_bscs3b";

        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "evaluation_system";

        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            echo $conn->connect_error;
        } else {
            return $conn;
        }
    }
?>