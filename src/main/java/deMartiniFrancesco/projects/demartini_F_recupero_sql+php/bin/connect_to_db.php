<?php
$host = "localhost";
$username = "18606";
$password = "password";
$db_name = "18606";
$con;
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password, array(PDO::ATTR_PERSISTENT => true));
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

// to handle connection error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}

function queryToDb(string $sql) : PDOStatement
{
    global $con;
    try {
        $result = $con->query($sql);
    } catch (PDOException $ex) {
        print("Errore !" . $ex->getMessage());
    }
    return $result;
}
