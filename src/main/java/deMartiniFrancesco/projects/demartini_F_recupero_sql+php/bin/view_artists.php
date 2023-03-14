<?php
require_once("connect_to_db.php");

$sql = "SELECT * FROM artista";
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
            <li><?php echo $row['descr']; ?></li>
        <?php endwhile; ?>
    </ul>
</body>

</html>
