<html>

<body>
    <form action="index.php">
        <input type="button" onclick="location.href='index.php';" value="Go to Hompage" />
    </form>
    <form action="" method="post">
        <label>Utente</label>
        <input type="number" name="user" id="user" value="">
        <label>Data</label>
        <input type="date" name="date" id="date" value="">
        <button type="submit" name="ok">OK</button>
    </form>
    <?php
    if (isset($_POST['ok'])) {
        require "connect_to_db.php";
        $sql = "SELECT * FROM ordinazioni WHERE utente=" . $_POST['user'] . " AND data=" . $_POST['date'];
        $result = queryToDb($sql);
        if ($result->rowCount() > 0) {
            echo "<b>Utente: " . $_POST['user']. "</b>";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $price = $row['price'];
                $items = $row['items'];
                echo "<p>Order ID: $id</p>";
                echo "<p>Total Price: $price</p>";
                echo "<p>Items: $items</p>";
            }
        } else {
            echo "0 results";
        }
    }
    ?>
</body>

</html>
