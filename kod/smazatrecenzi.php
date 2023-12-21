<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Smazat recenzi</title>
</head>
<body>
    <?php
    // Připojení k databázi
    $servername = "localhost";
    $username = "kolar17";
    $password = "Tis*8918298";
    $dbname = "kolar17";
     
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Zkontroluje, zda bylo předáno ID recenze
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id_recenze = $_GET['id'];

        // Dotaz pro smazání recenze
        $sql = "DELETE FROM recenze WHERE recenze.id_recenze = $id_recenze";

        if ($conn->query($sql) === TRUE) {
            echo "Recenze byla úspěšně smazána.";
            echo '<br><a href="precistrecenze.php"><button>Zpět na recenze</button></a>'; // Přidání tlačítka
        } else {
            echo "Chyba při mazání recenze: " . $conn->error;
        }
    } else {
        echo "Nebylo předáno ID recenze k odstranění.";
    }

    $conn->close();
    ?>
</body>
</html>
