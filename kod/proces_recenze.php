<?php
$servername = "localhost";
$username = "kolar17";
$password = "Tis*8918298";
$dbname = "kolar17";

// Připojení k databázi
$conn = new mysqli($servername, $username, $password, $dbname);

// Ověření připojení k databázi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Získání dat z formuláře
$article_id = $_POST['article_id'];
$review = $_POST['review'];

// Přidání recenze do databáze
$sql = "INSERT INTO recenze (id_clanku, obsah_recenze) VALUES ('$article_id', '$review')";

if ($conn->query($sql) === TRUE) {
    // Přesměrování na casopis.php
    header("Location: casopis.php");
    exit(); // Ukončení provádění kódu po přesměrování
} else {
    echo "Chyba při přidávání recenze: " . $conn->error;
}

$conn->close();
?>
