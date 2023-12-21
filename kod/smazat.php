<?php
$servername = "localhost";
$username = "kolar17";
$password = "Tis*8918298";
$dbname = "kolar17";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ověření, zda bylo odesláno ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_clanku = $_GET['id'];

    // Odstranění cizích klíčů
    $conn->query("SET FOREIGN_KEY_CHECKS=0");

    // Odstranění hodnocení
    $stmt_del_hodnoceni = $conn->prepare("DELETE FROM hodnoceni WHERE id_clanku = ?");
    $stmt_del_hodnoceni->bind_param("i", $id_clanku);
    $stmt_del_hodnoceni->execute();
    $stmt_del_hodnoceni->close();

    // Odstranění článku
    $stmt_del_clanek = $conn->prepare("DELETE FROM clanky WHERE id_clanku = ?");
    $stmt_del_clanek->bind_param("i", $id_clanku);

    if ($stmt_del_clanek->execute()) {
        // Přesměrování na jinou stránku
        header("Location: casopis.php");
        exit(); // Ukončení provádění kódu po přesměrování
    }

    $stmt_del_clanek->close();

    // Znovu zapnutí cizích klíčů
    $conn->query("SET FOREIGN_KEY_CHECKS=1");
} else {
    // Případné přesměrování, pokud není poskytnuto ID článku
    header("Location: casopis.php");
    exit(); // Ukončení provádění kódu po přesměrování
}

$conn->close();
?>
