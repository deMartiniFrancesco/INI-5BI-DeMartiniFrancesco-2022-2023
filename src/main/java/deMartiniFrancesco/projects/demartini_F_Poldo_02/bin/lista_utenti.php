<html>

<head>
    <style>
    table {
        border-collapse: collapse
    }

    td,
    th {
        border: 1px solid #ddd;
        padding: 8px;
    }
    </style>
</head>

<body>
    <form action="index.php">
        <input type="button" onclick="location.href='index.php';" value="Go to Hompage" />
    </form>

    <?php
        require "connect_to_db.php";
        $sql = "SELECT * FROM utenti";
        $result = queryToDb($sql);

        if ($result->rowCount() > 0) {
            echo "<table>";
            echo "<thead>";
            echo "<tr><td>Codice</td><td>Nome</td></tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['codice'];
                $name = $row['nome'];
                echo "<tr><td>$id</td><td>$name</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "0 results";
        }
        ?>
</body>

</html>