<!DOCTYPE html>
<html>
<head>
	<title>Modifica Importo Danno Auto Coinvolta</title>
</head>
<body>
	<h1>Modifica Importo Danno Auto Coinvolta</h1>
	<?php
	require_once("connect_to_db.php");
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$cods = $_POST["cods"];
		$targa = $_POST["targa"];
		$importodanno = $_POST["importodanno"];

		$sql = "UPDATE autocoinvolta SET importodanno = :importodanno WHERE cods = :cods AND targa = :targa";
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":cods", $cods, PDO::PARAM_STR);
		$stmt->bindValue(":targa", $targa, PDO::PARAM_STR);
		$stmt->bindValue(":importodanno", $importodanno, PDO::PARAM_INT);
		$result = $stmt->execute();

		// Verifica se l'aggiornamento è stato effettuato con successo
		if ($result) {
			echo "<p>Importo danno dell'auto coinvolta modificato con successo!</p>";
		} else {
			echo "<p>Si è verificato un errore durante la modifica dell'importo danno dell'auto coinvolta.</p>";
		}
	}
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="cods">Codice sinistro:</label>
		<input type="text" name="cods" id="cods" required><br><br>
		<label for="targa">Targa:</label>
		<input type="text" name="targa" id="targa" required><br><br>
		<label for="importodanno">Importo danno:</label>
		<input type="number" name="importodanno" id="importodanno" required><br><br>
		<input type="submit" value="Modifica importo danno">
	</form>
	<button onclick="location.href='index.php'">Back to Home</button>
</body>
</html>
