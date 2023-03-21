<?php
$host = "172.16.1.99";
$username = "utsinistri";
$password = "pwsinistri";
$db_name = "dbsinistri";
$con;
try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password, array(PDO::ATTR_PERSISTENT => true));
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

// to handle connection error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}

function queryToDb(string $sql): PDOStatement
{
    global $con;
    try {
        $result = $con->query($sql);
    } catch (PDOException $ex) {
        print("Errore !" . $ex->getMessage());
    }
    return $result;
}

?>