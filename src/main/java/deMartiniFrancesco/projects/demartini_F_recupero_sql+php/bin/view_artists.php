<?php
require_once("connect_to_db.php");

$sql = "SELECT DISTINCT artista FROM canzoni ORDER BY artista";
$result = queryToDb($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Visualizza tutti gli artisti</title>
</head>

<body>
    <h1>Elenco di tutti gli artisti</h1>
    <ul>
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
            <li><?php echo $row['artista']; ?></li>
        <?php endwhile; ?>
    </ul>
</body>

</html>
