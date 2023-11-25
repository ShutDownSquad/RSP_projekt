<?php
// Připojení k databázi 
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "SDS_DB";

// Vytvoření připojení
$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}
?>
