<?php
require 'connect.php';

// Získání nových zpráv od poslední aktualizace
$posledniAktualizace = isset($_GET['posledniAktualizace']) ? $_GET['posledniAktualizace'] : null;

$sql = "SELECT zpravy.obsah, uzivatel.jmeno, uzivatel.role, zpravy.cas FROM zpravy
        JOIN uzivatel ON zpravy.uzivatel_id = uzivatel.id
        WHERE zpravy.cas > '$posledniAktualizace'
        ORDER BY zpravy.cas DESC";

$result = $spojeni->query($sql);

$novyObsah = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $novyObsah .= "<p class='$messageClass'><strong>" . $row['jmeno'] . ":</strong> " . $row['obsah'] . " <small>" . $row['cas'] . "</small></p>";
    }
}

echo $novyObsah;
?>
