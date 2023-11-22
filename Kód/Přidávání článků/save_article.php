<?php
include 'db_config.php';
include 'upload_file.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ověření role
    $userRole = $_POST['userRole'];
    if ($userRole !== 'autor') { //Lze přidat další role jak bude třeba
        echo json_encode(['status' => 'error', 'message' => 'Nemáte oprávnění přidávat články.']);
        exit;
    }

    // Přijímání dat z formuláře
    $articleTitle = $_POST['articleTitle'];
    $articleText = $_POST['articleText'];   
    $section = $_POST['section'];
    $tags = $_POST['tags'];
    $mediaFilePath = $_POST['mediaFilePath'];  // Zapisuje cestu k souboru

    // SQL dotaz pro vložení článku do databáze
    $sql = "INSERT INTO articles (title, text, section, tags, media_file) VALUES ('$articleTitle', '$articleText', '$section', '$tags', '$mediaFilePath')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Článek byl úspěšně uložen.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Chyba při ukládání článku: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Neplatný požadavek.']);
}

$conn->close();
?>
