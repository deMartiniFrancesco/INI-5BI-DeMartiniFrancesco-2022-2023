<?php
require "connect_to_db.php";

if (isset($_POST['ok'])) {

    $sql = "SELECT * FROM orders WHERE user_id=" . $_POST['user'];
    $result = queryToDb($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $date = $row['date'];
            echo "<p>$date</p>";
        }
    } else {
        echo "0 results";
    }
}
?>



<html>

<body>
    <form action="" method="post">
        <input type="text" name="user" id="user" value="Car Loan">
        <button type="submit" name="ok">OK</button>
    </form>
</body>

</html>