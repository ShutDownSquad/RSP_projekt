<?php
require 'connect.php';
session_start();

// Definice funkce odesliZpravu()
function odesliZpravu($uzivatel_id, $jmeno, $obsah) {
    global $spojeni;

    $obsah = htmlspecialchars($obsah);

    $sql = "INSERT INTO zpravy (uzivatel_id, obsah) VALUES ($uzivatel_id, '$obsah')";

    if ($spojeni->query($sql) === TRUE) {
        // Zpráva byla úspěšně odeslána
    } else {
        echo "Error: " . $sql . "<br>" . $spojeni->error;
    }
}

// Odeslání zprávy, pokud byl formulář odeslán
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["odeslat"])) {
    // Získání informací o přihlášeném uživateli z session
    $uzivatel_id = isset($_SESSION['ID']) ? $_SESSION['ID'] : null;
    $jmeno = isset($_SESSION['jmeno']) ? $_SESSION['jmeno'] : null;

    $obsah = $_POST["zprava"];

    // Ověření, zda máme dostatek informací o uživateli
    if ($uzivatel_id && $jmeno) {
        // Odeslání zprávy
        odesliZpravu($uzivatel_id, $jmeno, $obsah);
    } else {
        echo "Nepodařilo se získat dostatek informací o uživateli.";
    }
}

// Přesměrování zpět na chat.php
header("Location: chat.php");
exit();
?>
