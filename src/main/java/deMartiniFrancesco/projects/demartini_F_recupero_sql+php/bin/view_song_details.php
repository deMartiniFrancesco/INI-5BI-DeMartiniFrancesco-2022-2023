<?php
require_once("connect_to_db.php");

if (!isset($_GET['song_id'])) {
    echo "Errore: ID canzone non specificato.";
    exit;
}

$song_id = $_GET['song_id'];

// Ottieni informazioni sulla canzone
$sql = "SELECT * FROM brano WHERE id = $song_id";
$result = queryToDb($sql);
$song = $result->fetch(PDO::FETCH_ASSOC);

// Ottieni informazioni sull'artista della canzone
$sql = "SELECT * FROM artista WHERE id = " . $song['artist_id'];
$result = queryToDb($sql);
$artist = $result->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dettagli della canzone "<?php echo $song['song_name'] ?>"</title>
</head>
<body>
    <h1>Dettagli della canzone "<?php echo $song['song_name'] ?>"</h1>

    <ul>
        <li>Artista: <a href="view_artist_details.php?artist_id=<?php echo $artist['id'] ?>"><?php echo $artist['descr'] ?></a></li>
        <li>Durata: <?php echo $song['durata'] ?></li>
    </ul>
</body>
</html>
