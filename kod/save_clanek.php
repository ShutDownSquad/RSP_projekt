<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazev = $_POST['nazev'];
    $komentar = $_POST['komentar'];
    $sekce = $_POST['sekce'];
    $tagy = $_POST['tagy'];

    // Složka pro ukládání nahrávaných souborů
    $targetDirectory = '/home/kolar17/public_html/TIS/casopis/uploads/';
    $targetFile = $targetDirectory . basename($_FILES['pdf_file']['name']);

    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $targetFile)) {
        $pdf_path = $targetFile;

        // Připojení k databázi
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL dotaz pro vložení článku do databáze
        $sql = "INSERT INTO clanky (nazev, komentar, sekce, tagy, pdf_path)
                VALUES ('$nazev', '$komentar', '$sekce', '$tagy', '$pdf_path')";

        if ($conn->query($sql) === TRUE) {
            // Přesměrování na hlavní stránku
            header("Location: casopis.php");
            exit(); // Ukončení provádění kódu po přesměrování
        }

        $conn->close();
    }
}
?>
