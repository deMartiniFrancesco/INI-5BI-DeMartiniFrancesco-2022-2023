<!DOCTYPE html>
<html>
<head>
	<title>Aggiungi assicurazione</title>
</head>
<body>
	<h1>Aggiungi assicurazione</h1>
	<?php
	require_once("connect_to_db.php");
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	
	$sql = "INSERT INTO assicurazione (codass, nome, sede) VALUES (:codass, :nome, :sede)";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$codass = $_POST["codass"];
		$nome = $_POST["nome"];
		$sede = $_POST["sede"];

		$stmt = $con->prepare($sql);
		$stmt->bindValue(":codass", $codass, PDO::PARAM_STR);
		$stmt->bindValue(":nome", $nome, PDO::PARAM_STR);
		$stmt->bindValue(":sede", $sede, PDO::PARAM_STR);
		$result = $stmt->execute();

		// Verifica se l'inserimento è stato effettuato con successo
		if ($result) {
			echo "<p>Assicurazione inserita con successo!</p>";
		} else {
			echo "<p>Si è verificato un errore durante l'inserimento dell'assicurazione.</p>";
		}
	}
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label for="codass">Codice assicurazione:</label>
		<input type="text" name="codass" id="codass" required><br><br>
		<label for="nome">Nome:</label>
		<input type="text" name="nome" id="nome" required><br><br>
		<label for="sede">Sede:</label>
		<input type="text" name="sede" id="sede" required><br><br>
		<input type="submit" value="Aggiungi assicurazione">
	</form>
	<button onclick="location.href='index.php'">Back to Home</button>
</body>
</html>
