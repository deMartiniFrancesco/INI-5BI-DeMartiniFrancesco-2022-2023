<?php
require_once("connect_to_db.php");

if (!isset($_GET['album_id'])) {
    echo "Errore: ID album non specificato.";
    exit;
}

$album_id = $_GET['album_id'];

// Ottieni informazioni sull'album
$sql = "SELECT * FROM albums WHERE album_id = $album_id";
$result = queryToDb($sql);
$album = $result->fetch(PDO::FETCH_ASSOC);

// Ottieni le canzoni dell'album
$sql = "SELECT * FROM songs WHERE album_id = $album_id";
$result = queryToDb($sql);
$songs = $result->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Canzoni dell'album "<?php echo $album['album_name'] ?>"</title>
</head>

<body>
    <h1>Canzoni dell'album "<?php echo $album['album_name'] ?>"</h1>

    <?php if (count($songs) > 0) : ?>
        <ul>
            <?php foreach ($songs as $song) : ?>
                <li><?php echo $song['song_name'] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>Nessuna canzone trovata per questo album.</p>
    <?php endif; ?>
</body>

</html>