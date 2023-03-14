<?php
require_once("connect_to_db.php");

$sql = "SELECT DISTINCT album FROM brani ORDER BY album";
$result = queryToDb($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Visualizza tutti gli album</title>
</head>

<body>
    <h1>Elenco di tutti gli album</h1>
    <ul>
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) : ?>
            <li><?php echo $row['album']; ?></li>
        <?php endwhile; ?>
    </ul>
</body>

</html>
