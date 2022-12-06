<!DOCTYPE html>
<html>

<head>
    <style>
    .card {
        background: #b3b3b3;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 500px;
        margin: auto;
        text-align: center;
        font-family: arial;
    }

    .card h1 {
        padding: 5px;
    }

    .price {
        color: grey;
        font-size: 22px;
    }

    .card button {
        border: none;
        outline: 0;
        padding: 12px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
    }

    .card button:hover {
        opacity: 0.7;
    }
    </style>
</head>

<body>
    <form action="index.php">
        <input type="button" onclick="location.href='index.php';" value="Go to Hompage" />
    </form>
    <h2 style="text-align:center">Listino</h2>

    <?php 
    require "connect_to_db.php";
    $sql = "SELECT * FROM cibo";
    $result = queryToDb($sql);

    if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='card'>";
            $image = "http://172.16.1.99/imgpoldo/" . $row["img"];
            if (@getimagesize($image)) {
                echo '<img src="' . $image . '" alt="'. $row["nome"] . '" width="100" height="100">';
            }
            

            echo "<h1>" . $row["nome"] . "</h1>";
            echo "<p class='price'>$" . $row["prezzo"] . "</p>";
            echo "<p><button>Informazioni</button></p>";
            echo "</div><br>";
        }
    } else {
        echo "0 results";
    }
    ?>

</body>

</html>