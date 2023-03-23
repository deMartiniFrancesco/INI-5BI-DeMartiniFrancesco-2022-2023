<!DOCTYPE html>
<html>
<head>
	<title>Aggiungi auto</title>
</head>
<body>
	<h1>Aggiungi auto</h1>
	<?php
	require_once("connect_to_db.php");
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);

	$sql = "INSERT INTO auto (targa, marca, cilindrata, potenza, codf, codass) VALUES (:targa, :marca, :cilindrata, :potenza, :codf, :codass)";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$targa = $_POST["targa"];
		$marca = $_POST["marca"];
		$cilindrata = $_POST["cilindrata"];
		$potenza = $_POST["potenza"];
		$codf = $_POST["codf"];
		$codass = $_POST["codass"];

		$stmt = $con->prepare($sql);
		$stmt->bindValue(":targa", $targa, PDO::PARAM_STR);
		$stmt->bindValue(":marca", $marca, PDO::PARAM_STR);
		$stmt->bindValue(":cilindrata", $cilindrata, PDO::PARAM_INT);
		$stmt->bindValue(":potenza", $potenza, PDO::PARAM_INT);
		$stmt->bindValue(":codf", $codf, PDO::PARAM_STR);
		$stmt->bindValue(":codass", $codass, PDO::PARAM_STR);
		$result = $stmt->execute();

		// Verifica se l'inserimento è stato effettuato con successo
		if ($result) {
			echo "<p>Auto inserita con successo!</p>";
		} else {
			echo "<p>Si è verificato un errore durante l'inserimento dell'auto.</p>";
		}
	}
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="targa">Targa:</label>
		<input type="text" name="targa" id="targa" required><br><br>
		<label for="marca">Marca:</label>
		<input type="text" name="marca" id="marca" required><br><br>
		<label for="cilindrata">Cilindrata:</label>
		<input type="number" name="cilindrata" id="cilindrata"><br><br>
		<label for="potenza">Potenza:</label>
		<input type="number" name="potenza" id="potenza"><br><br>
		<label for="codf">Codice fiscale proprietario:</label>
		<input type="text" name="codf" id="codf" required><br><br>
		<label for="codass">Codice assicurazione:</label>
		<input type="text" name="codass" id="codass"><br><br>
		<input type="submit" value="Aggiungi auto">
	</form>
	<button onclick="location.href='index.php'">Back to Home</button>
</body>
</html>
