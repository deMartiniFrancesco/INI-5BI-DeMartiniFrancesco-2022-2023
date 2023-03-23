<!DOCTYPE html>
<html>

<head>
    <title>Visualizza sinistri</title>
</head>

<body>
    <h1>Visualizza sinistri</h1>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="da">Da:</label>
        <input type="date" name="da" id="da"><br><br>
        <label for="a">A:</label>
        <input type="date" name="a" id="a"><br><br>
        <input type="submit" value="Filtra">
    </form>
    <?php
    require_once("connect_to_db.php");
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    $sql = "SELECT * FROM sinistro";
    $condizioni = array();

    if (isset($_GET["da"]) && !empty($_GET["da"])) {
        $condizioni[] = "data >= :da";
    }
    if (isset($_GET["a"]) && !empty($_GET["a"])) {
        $condizioni[] = "data <= :a";
    }

    if (!empty($condizioni)) {
        $sql .= " WHERE " . implode(" AND ", $condizioni);
    }

    $stmt = $con->prepare($sql);

    if (isset($_GET["da"]) && !empty($_GET["da"])) {
        $da = $_GET["da"];
        $stmt->bindValue(":da", $da, PDO::PARAM_STR);
    }
    if (isset($_GET["a"]) && !empty($_GET["a"])) {
        $a = $_GET["a"];
        $stmt->bindValue(":a", $a, PDO::PARAM_STR);
    }

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) > 0) {
        echo "<table>";
        echo "<tr><th>Codice sinistro</th><th>Località</th><th>Data</th><th>Dettagli</th></tr>";
        foreach ($rows as $row) {
            echo "<tr><td>" . $row["cods"] . "</td><td>" . $row["localita"] . "</td><td>" . $row["data"] . "</td><td><a href=\"dettaglio_sinistro.php?cods=" . $row["cods"] . "\">Dettagli</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nessun sinistro trovato.</p>";
    }
    ?>
    <button onclick="location.href='index.php'">Back to Home</button>
</body>

</html>