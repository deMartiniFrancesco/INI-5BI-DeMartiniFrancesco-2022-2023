<!DOCTYPE html>
<html>
<head>
	<title>Aggiungi proprietario</title>
</head>
<body>
	<h1>Aggiungi proprietario</h1>
	<?php
	require_once("connect_to_db.php");
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	
	$sql = "INSERT INTO proprietario (codf, nome, residenza) VALUES (:codf, :nome, :residenza)";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$codf = $_POST["codf"];
		$nome = $_POST["nome"];
		$residenza = $_POST["residenza"];

		$stmt = $con->prepare($sql);
		$stmt->bindValue(":codf", $codf, PDO::PARAM_STR);
		$stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
		$stmt->bindValue(":residenza", $residenza, PDO::PARAM_STR);
		$result = $stmt->execute();

		// Verifica se l'inserimento è stato effettuato con successo
		if ($result) {
			echo "<p>Proprietario inserito con successo!</p>";
		} else {
			echo "<p>Si è verificato un errore durante l'inserimento del proprietario.</p>";
		}
	}
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="codf">Codice fiscale:</label>
		<input type="text" name="codf" id="codf" required><br><br>
		<label for="nome">Nome:</label>
		<input type="text" name="nome" id="nome" required><br><br>
		<label for="residenza">Residenza:</label>
		<input type="text" name="residenza" id="residenza" required><br><br>
		<input type="submit" value="Aggiungi proprietario">
	</form>
	<button onclick="location.href='index.php'">Back to Home</button>
</body>
</html>
