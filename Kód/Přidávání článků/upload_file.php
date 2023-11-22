<?php
$targetDirectory = 'uploads/'; //Změnit dle složky do které se to bude posílat
$targetFile = $targetDirectory . basename($_FILES['mediaFile']['name']);

if (move_uploaded_file($_FILES['mediaFile']['tmp_name'], $targetFile)) {
    echo json_encode(['status' => 'success', 'message' => 'Soubor byl úspěšně nahrán.', 'file_path' => $targetFile]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Chyba při nahrávání souboru.']);
}
?>
