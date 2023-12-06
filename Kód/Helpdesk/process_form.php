<?php

include 'connect.php';


if ($_SERVER['REQUEST_METHOD' === 'POST']) {

    // Získání dat z formuláře
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $email = $_POST['email'];

    // Uložení dat do databáze
    $sql = "INSERT INTO helpdesk (subject, description, email) VALUES ('$subject', '$description', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Zpráva úspěšně odeslána']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Chyba při ukládání' . $conn->error]);
    }

    // Zavření spojení s databází   
} else {
    echo json_encode(['status' => 'error', 'message' => 'Neplatný požadavek.']);
}

$conn->close();
?>