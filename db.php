<?php
        $connection = new mysqli('localhost:3307', 'root', '', 'philhealth membership registration');
        if ($connection -> connect_error){
            die('Connection Failed : '.$connection->connect_error);
        }
?>