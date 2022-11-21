<?php 
require "connect_to_db.php";
$sql = "SELECT * FROM cibo";
$result = queryToDb($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<h3>" . $row["nome"] . "</h3>";
        echo "<p>" . $row["prezzo"] . "$</p>";
        echo '<img src="http://172.16.1.99/imgpoldo/' . $row["img"] . '" alt="'. $row["nome"] . '" width="100" height="100"><br><br>';
        echo "<hr>";
    }
} else {
    echo "0 results";
}

