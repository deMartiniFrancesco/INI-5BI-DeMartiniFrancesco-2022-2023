<?php
require "connect_to_db.php";
$sql = "SELECT * FROM utenti";
$result = queryToDb($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $id = $row['codice'];
        $name = $row['nome'];
        echo "<p>$id - $name</p>";
    }
}
else {
    echo "0 results";
}
?>
        




