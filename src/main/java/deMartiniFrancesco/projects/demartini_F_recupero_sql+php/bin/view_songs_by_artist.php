<?php
require_once "connect_to_db.php";

if(isset($_GET["artist_id"])) {
    $artist_id = $_GET["artist_id"];

    $query = "SELECT s.title, a.name AS artist_name, al.title AS album_title 
              FROM songs s 
              INNER JOIN artists a ON s.artist_id = a.id 
              INNER JOIN albums al ON s.album_id = al.id 
              WHERE s.artist_id = :artist_id";
    
    $stmt = $con->prepare($query);
    $stmt->bindValue(":artist_id", $artist_id, PDO::PARAM_INT);
    $stmt->execute();
    $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Canzoni di un artista</title>
    <style>
        table {
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <?php if(isset($songs)): ?>
        <h2>Canzoni dell'artista:</h2>
        <table>
            <thead>
                <tr>
                    <th>Titolo</th>
                    <th>Artista</th>
                    <th>Album</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($songs as $song): ?>
                    <tr>
                        <td><?php echo $song["title"]; ?></td>
                        <td><?php echo $song["artist_name"]; ?></td>
                        <td><?php echo $song["album_title"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Artista non trovato.</p>
    <?php endif; ?>
</body>
</html>
