<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlavní stránka</title>
</head>
<body>

    <h1>Články na hlavní stránce</h1>

    <?php
    include 'db_config.php';

    // Načtení článků z databáze
    $sql = "SELECT * FROM articles";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Výpis článků
        while ($row = $result->fetch_assoc()) {
            echo '<div>';
            echo '<h2>' . $row['title'] . '</h2>';
            echo '<p>' . $row['text'] . '</p>';

            // Odkaz na PDF soubor
            echo '<p><a href="' . $row['media_file'] . '" target="_blank">Zobraz</a></p>';

            // Můžete přidat další informace o článku, jako je autor, datum atd.
            echo '</div>';
        }
    } else {
        echo '<p>Žádné články k zobrazení.</p>';
    }

    $conn->close();
    ?>

</body>
</html>
