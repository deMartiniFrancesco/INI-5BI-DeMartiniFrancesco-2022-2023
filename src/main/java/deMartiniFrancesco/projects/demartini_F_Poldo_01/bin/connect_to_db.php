<?php

function queryToDb(string $sql): mysqli_result
{
    $host = "172.16.1.99";
    $username = "poldo";
    $password = "poldo";
    $dbname = "poldo";


    // Create connection
    $conn = new mysqli($host, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($sql);

    $conn->close();

    return $result;
}
