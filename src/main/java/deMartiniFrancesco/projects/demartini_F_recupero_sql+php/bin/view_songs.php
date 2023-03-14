<?php
require_once("connect_to_db.php");

$sql = "SELECT * FROM brano";
$result = queryToDb($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Visualizza tutte le canzoni</title>
</head>

<body>
    <h1>Elenco di tutte le canzoni</h1>
    <table>
        <tr>
            <th>Titolo</th>
            <th>Durata</th>
            <th>Artista</th>
        </tr>
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['titolo']; ?></td>
                <td><?php echo $row['durata']; ?></td>
                <td><?php echo $row['idartista']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>
