<?php
// Připojení k databázi
include 'connect.php';

// Kontrola, zda byl formulář odeslán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získání hodnot z formuláře
    $articleTitle = $_POST['articleTitle'];
    $articleText = $_POST['articleText'];
    $section = $_POST['section'];
    $tags = $_POST['tags'];

    // Příprava dotazu na aktualizaci dat v tabulce "clanek"
    $sql = "UPDATE clanek SET nazev='$articleTitle', komentar='$articleText', sekce='$section', tagy='$tags' WHERE id=?"; 

    // Spuštění dotazu
    if ($conn->query($sql) === TRUE) {
        echo "Data byla úspěšně aktualizována.";
    } else {
        echo "Chyba při aktualizaci dat: " . $conn->error;
    }
}

// Uzavření připojení k databázi
$conn->close();
?>
