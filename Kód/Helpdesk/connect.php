<?php
define($servername = "localhost");  // Změňte na správnou hodnotu
define($username = "root");    // Změňte na správnou hodnotu
define($password = "");        // Změňte na správnou hodnotu
define($dbname = "rsp_casopis");  // Změňte na správnou hodnotu

// Vytvoření připojení
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Připojení k databázi selhalo: " . $conn->connect_error);
}
?>