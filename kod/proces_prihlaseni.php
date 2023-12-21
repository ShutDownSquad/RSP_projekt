<?php
require 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jmeno = $_POST['jmeno'];
    $heslo = $_POST['heslo'];

    // Dotaz pro získání uloženého hashe hesla z databáze
    $sql = "SELECT id, jmeno, heslo, role, image_path FROM uzivatel WHERE jmeno='$jmeno'";
    $result = $spojeni->query($sql);

    if ($result->num_rows == 1) {
        // Uživatel nalezen, porovnání hesel
        $row = $result->fetch_assoc();
        $hashed_password = $row['heslo'];

        if (password_verify($heslo, $hashed_password)) {
            // Hesla se shodují, uživatel ověřen, uložení do session
            $_SESSION['ID'] = $row['id'];
            $_SESSION['jmeno'] = $jmeno;
            $_SESSION['role'] = $row['role']; // Uložení role do session
            $_SESSION['image_path'] = $row['image_path'];

            if ($row['role'] == 'admin') {
                header("Location: casopis.php");
            } else {
                header("Location: casopis.php");
            }
            exit();
        } else {
            echo "Neplatné jméno nebo heslo.";
        }
    } else {
        echo "Uživatel nenalezen.";
    }
}

$spojeni->close();
?>