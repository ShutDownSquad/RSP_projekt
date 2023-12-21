<?php
// Připojení k databázi (nastavte vlastní přihlašovací údaje)
$servername = "localhost";
$username = "kolar17";
$password = "Tis*8918298";
$dbname = "kolar17";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
// Kontrola připojení
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
// Získání cesty k PDF souboru z databáze (předpokládáme, že máte sloupec s názvem 'pdf_path')
$sql = "SELECT pdf_path FROM clanky";
$result = $conn->query($sql);
 
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdfPath = $row["pdf_path"];
 
        // Složka, kde jsou PDF soubory uloženy ve vašem projektu
        $uploadFolder = "";
 
        // Úplná cesta k PDF souboru
        $fullPath = $pdfPath;
 
        // Kontrola existence souboru
        if (file_exists($fullPath)) {
            // Nastavení hlaviček pro stahování
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=' . basename($fullPath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fullPath));
 
            // Otevření souboru pro čtení a výstup na výstupní buffer
            readfile($fullPath);
            exit;
        } else {
            echo "Soubor neexistuje: " . $fullPath;
        }
    }
} else {
    echo "Nebyly nalezeny žádné záznamy.";
}
 
// Uzavření připojení k databázi
$conn->close();
?>