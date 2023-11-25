<?php
// Připojení k databázi
include 'db_config.php';

// Získání ID článku
$articleId = $_GET['id'];

// Aktualizace stavu článku na "Publikováno"
$sql = "UPDATE articles SET status = 'Publikováno' WHERE id = $articleId";
$conn->query($sql);

// Zavření spojení s databází
$conn->close();

// Přesměrování zpět na hlavní stránku nebo jinou vhodnou stránku
header('Location: zobraz_pdf.php');
exit();
?>
