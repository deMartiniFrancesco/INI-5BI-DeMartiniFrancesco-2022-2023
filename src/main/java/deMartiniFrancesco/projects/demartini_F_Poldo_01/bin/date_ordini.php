<html>

<body>
    <form action="index.php">
        <input type="button" onclick="location.href='index.php';" value="Go to Hompage" />
    </form>
    <form action="" method="post">
        <label>Utente</label>
        <input type="number" name="user" id="user" value="">
        <button type="submit" name="ok">OK</button>
    </form>
    <?php
    if (isset($_POST['ok'])) {
        require "connect_to_db.php";
        $sql = "SELECT * FROM ordinazioni WHERE utente=" . $_POST['user'];
        $result = queryToDb($sql);
        if ($result->rowCount() > 0) {
            echo "<b>Utente: " . $_POST['user']. "</b>";
            $num = 0;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $num++;
                $data = $row['data'];
                echo "<p>$num) $data<br></p>";
            }
        } else {
            echo "0 results";
        }
    }
    ?>
</body>

</html>