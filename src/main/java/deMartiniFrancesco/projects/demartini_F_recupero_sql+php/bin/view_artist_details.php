<?php
require_once("connect_to_db.php");

if (!isset($_GET['artist_id'])) {
    header("Location: view_artists.php");
    exit();
}

$artist_id = $_GET['artist_id'];

$sql = "SELECT * FROM artista WHERE idartista = {$artist_id}";
$result = queryToDb($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header("Location: view_artists.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dettagli artista</title>
</head>

<body>
    <h1>Dettagli artista</h1>
    <p><strong>Nome:</strong> <?php echo $row['nome']; ?></p>
    <p><strong>Nazione:</strong> <?php echo $row['nazione']; ?></p>
    <p><strong>Genere:</strong> <?php echo $row['genere']; ?></p>
</body>

</html>
