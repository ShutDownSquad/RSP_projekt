<!-- proces_hodnoceni.php -->

<?php
$servername = "localhost";
$username = "kolar17";
$password = "Tis*8918298";
$dbname = "kolar17";
 
$conn = new mysqli($servername, $username, $password, $dbname);

// Získání dat z formuláře
$article_id = $_POST['article_id'];
$rating = $_POST['rating'];

// Přidání hodnocení do tabulky hodnoceni
$sql = "INSERT INTO hodnoceni (id_clanku, hodnoceni_cislo) VALUES ('$article_id', '$rating')";

$updateQuery = "UPDATE clanky SET hodnoceni = (SELECT AVG(hodnoceni_cislo) FROM hodnoceni WHERE id_clanku = $article_id) WHERE id_clanku = $article_id";

if ($conn->query($sql) === TRUE) {
    echo "Hodnocení bylo úspěšně přidáno.";
    echo '<br><a href="casopis.php"><button>Přejít na časopis</button></a>'; // Přidání tlačítka
} else {
    echo "Chyba při přidávání hodnocení: " . $conn->error;
}
// Spuštění aktualizace hodnocení v tabulce clanky
if ($conn->query($updateQuery) === TRUE) {
    echo "Hodnocení článku bylo úspěšně aktualizováno.";
    // Pokračování s dalšími akcemi nebo přechod na jinou stránku
} else {
    echo "Chyba při aktualizaci hodnocení článku: " . $conn->error;
}




$conn->close();
?>
