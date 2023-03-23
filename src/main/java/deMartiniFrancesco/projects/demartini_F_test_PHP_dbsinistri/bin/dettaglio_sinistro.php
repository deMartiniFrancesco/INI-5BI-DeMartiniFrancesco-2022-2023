<!DOCTYPE html>
<html>
<head>
	<title>Dettaglio Sinistro</title>
</head>
<body>
	<h1>Dettaglio Sinistro</h1>
	<?php
	require_once("connect_to_db.php");
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
	
	if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["cods"])) {
		$cods = $_GET["cods"];

		// Recupera le informazioni del sinistro
		$sql = "SELECT * FROM sinistro WHERE cods = :cods";
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":cods", $cods, PDO::PARAM_STR);
		$stmt->execute();
		$sinistro = $stmt->fetch(PDO::FETCH_ASSOC);

		// Recupera le auto coinvolte nel sinistro
		$sql = "SELECT autocoinvolta.targa, auto.marca, autocoinvolta.importodanno, proprietario.nome AS proprietario_nome 
				FROM autocoinvolta 
				INNER JOIN auto ON autocoinvolta.targa = auto.targa 
				INNER JOIN proprietario ON auto.codf = proprietario.codf 
				WHERE autocoinvolta.cods = :cods";
		$stmt = $con->prepare($sql);
		$stmt->bindValue(":cods", $cods, PDO::PARAM_STR);
		$stmt->execute();
		$auto_coinvolte = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if (!$sinistro) {
			echo "<p>Sinistro non trovato.</p>";
		} else {
			echo "<h2>Informazioni Sinistro</h2>";
			echo "<table>";
			echo "<tr><td>Codice Sinistro:</td><td>" . $sinistro["cods"] . "</td></tr>";
			echo "<tr><td>Località:</td><td>" . $sinistro["localita"] . "</td></tr>";
			echo "<tr><td>Data:</td><td>" . $sinistro["data"] . "</td></tr>";
			echo "</table>";

			echo "<h2>Auto Coinvolte</h2>";
			if (!$auto_coinvolte) {
				echo "<p>Nessuna auto coinvolta.</p>";
			} else {
				echo "<table>";
				echo "<thead><tr><th>Targa</th><th>Marca</th><th>Proprietario</th><th>Importo Danno</th></tr></thead>";
				echo "<tbody>";
				foreach ($auto_coinvolte as $auto) {
					echo "<tr>";
					echo "<td>" . $auto["targa"] . "</td>";
					echo "<td>" . $auto["proprietario_nome"] . "</td>";
					echo "<td>" . $auto["importodanno"] . "</td>";
					echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";
			}
		}
	} else {
		echo "<p>Si è verificato un errore nella Dettagliozione del sinistro.</p>";
	}
	?>
	<button onclick="location.href='index.php'">Back to Home</button>
</body>
</html>
