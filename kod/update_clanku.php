<?php
// Připojení k databázi

$servername = "localhost";
$username = "kolar17";
$password = "Tis*8918298";
$dbname = "kolar17";
$spojeni = mysqli_connect($servername, $username, $password, $dbname);

// Kontrola připojení k databázi
if (!$spojeni) {
    die("Chyba při připojování k databázi: " . mysqli_connect_error());
}

mysqli_set_charset($spojeni, "utf8");

// Kontrola, zda byl formulář odeslán
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získání hodnot z formuláře
    $articleTitle = $_POST['nazev'];
    $articleText = $_POST['komentar'];
    $id_clanku = $_POST['id_clanku']; // Předpokládáme, že tato hodnota je dostupná v formuláři

    // Příprava dotazu na aktualizaci názvu a popisu článku v tabulce "clanky"
    $sql = "UPDATE clanky SET nazev=?, komentar=? WHERE id_clanku=?"; 

    // Spuštění dotazu
    $stmt = mysqli_prepare($spojeni, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $articleTitle, $articleText, $id_clanku);

    if (mysqli_stmt_execute($stmt)) {
        // Přesměrování na hlavní stránku po úspěšné aktualizaci
        header("Location: casopis.php");
        exit();
    } else {
        echo "Chyba při aktualizaci dat: " . mysqli_error($spojeni);
    }

    // Uzavření připraveného dotazu
    mysqli_stmt_close($stmt);
}

// Uzavření připojení k databázi
mysqli_close($spojeni);
?>
