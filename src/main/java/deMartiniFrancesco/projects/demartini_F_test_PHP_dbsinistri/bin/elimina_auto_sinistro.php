<!DOCTYPE html>
<html>

<head>
    <title>Elimina auto coinvolta in sinistro</title>
</head>

<body>
    <h1>Elimina auto coinvolta in sinistro</h1>
    <?php
    require_once("connect_to_db.php");
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    // Verifica se è stata inviata una richiesta POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $targa = $_POST["targa"];
        $cods = $_POST["cods"];

        // Elimina l'auto coinvolta dal sinistro
        $sql = "DELETE FROM autocoinvolta WHERE targa = :targa AND cods = :cods";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(":targa", $targa, PDO::PARAM_STR);
        $stmt->bindValue(":cods", $cods, PDO::PARAM_STR);
        $result = $stmt->execute();

        // Verifica se l'eliminazione è stata effettuata con successo
        if ($result) {
            echo "<p>Auto eliminata con successo dal sinistro!</p>";
        } else {
            echo "<p>Si è verificato un errore durante l'eliminazione dell'auto dal sinistro.</p>";
        }
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="targa">Targa dell'auto:</label>
        <input type="text" name="targa" id="targa" required><br><br>
        <label for="cods">Codice del sinistro:</label>
        <input type="text" name="cods" id="cods" required><br><br>
        <input type="submit" value="Elimina auto">
    </form>
    <button onclick="location.href='index.php'">Back to Home</button>
</body>

</html>