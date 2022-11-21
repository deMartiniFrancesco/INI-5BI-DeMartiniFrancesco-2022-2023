<?php
require "connect_to_db.php";
$sql = "SELECT * FROM orders WHERE codice=" . $_GET['user_id'] . " AND date='" . $_GET['date'] . "'";
$result = queryToDb($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $id = $row['id'];
        $price = $row['price'];
        $items = $row['items'];
        echo "<p>Order ID: $id</p>";
        echo "<p>Total Price: $price</p>";
        echo "<p>Items: $items</p>";
    }
}
?>