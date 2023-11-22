<?php
define('DB_HOST', 'localhost'); // Změňit na adresu vašeho MySQL serveru
define('DB_USER', 'root'); // Změňit na své uživatelské jméno MySQL
define('DB_PASSWORD', ''); // Změňit na své heslo MySQL
define('DB_NAME', 'clanky'); // Změňit na název vaší databáze

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
