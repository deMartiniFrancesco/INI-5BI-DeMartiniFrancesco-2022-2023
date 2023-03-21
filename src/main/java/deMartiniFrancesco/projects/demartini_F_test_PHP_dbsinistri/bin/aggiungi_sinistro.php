<!DOCTYPE html>
<html>

<head>
    <title>Aggiungi sinistro</title>
</head>

<body>
    <h1>Aggiungi sinistro</h1>
    <?php
    require_once("connect_to_db.php");
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    $sql = "INSERT INTO sinistro (cods, localita, data) VALUES (:cods, :localita, :data)";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cods = $_POST["cods"];
        $localita = $_POST["localita"];
        $data = $_POST["data"];

        $stmt = $con->prepare($sql);
        $stmt->bindValue(":cods", $cods, PDO::PARAM_STR);
        $stmt->bindValue(":localita", $localita, PDO::PARAM_STR);
        $stmt->bindValue(":data", $data, PDO::PARAM_STR);
        $result = $stmt->execute();

        // Verifica se l'inserimento è stato effettuato con successo
        if ($result) {
            echo "<p>Sinistro inserito con successo!</p>";
        } else {
            echo "<p>Si è verificato un errore durante l'inserimento del sinistro.</p>";
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="cods">Codice sinistro:</label>
        <input type="text" name="cods" id="cods" required><br><br>
        <label for="localita">Località:</label>
        <input type="text" name="localita" id="localita" required><br><br>
        <label for="data">Data:</label>
        <input type="date" name="data" id="data" required><br><br>
        <input type="submit" value="Aggiungi sinistro">
    </form>
    <button onclick="location.href='index.php'">Back to Home</button>
</body>

</html>