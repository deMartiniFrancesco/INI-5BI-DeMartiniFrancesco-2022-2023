<!DOCTYPE html>
<html>
<head>
	<title>Aggiungi auto coinvolta in un sinistro</title>
</head>
<body>
	<h1>Aggiungi auto coinvolta in un sinistro</h1>
	<?php
	require_once("connect_to_db.php");
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	
	$sql = "INSERT INTO autocoinvolta (cods, targa, importodanno) VALUES (:cods, :targa, :importodanno)";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$cods = $_POST["cods"];
		$targa = $_POST["targa"];
		$importodanno = $_POST["importodanno"];

		$stmt = $con->prepare($sql);
		$stmt->bindValue(":cods", $cods, PDO::PARAM_STR);
		$stmt->bindValue(":targa", $targa, PDO::PARAM_STR);
		$stmt->bindValue(":importodanno", $importodanno, PDO::PARAM_INT);
		$result = $stmt->execute();

		// Verifica se l'inserimento è stato effettuato con successo
		if ($result) {
			echo "<p>Auto coinvolta inserita con successo!</p>";
		} else {
			echo "<p>Si è verificato un errore durante l'inserimento dell'auto coinvolta.</p>";
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
		<input type="submit" value="Aggiungi auto coinvolta">
	</form>
	<button onclick="location.href='index.php'">Back to Home</button>
</body>
</html>
