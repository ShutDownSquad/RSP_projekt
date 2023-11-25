<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $articleId = $_POST['article_id'];
    $rating = $_POST['rating'];

    // Aktualizace hodnocení v databázi
    $updateSql = "UPDATE articles SET rating = $rating WHERE id = $articleId";
    $conn->query($updateSql);

    echo "Hodnocení bylo úspěšně uloženo.";
} else {
    echo "Neplatný požadavek.";
}

$conn->close();
?>
