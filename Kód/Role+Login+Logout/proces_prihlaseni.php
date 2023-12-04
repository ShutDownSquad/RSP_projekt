<?php
session_start();
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jmeno = $_POST['jmeno'];
    $heslo = $_POST['heslo'];

    // Dotaz pro získání uloženého hashe hesla z databáze
    $sql = "SELECT id, jmeno, heslo, role FROM uzivatel WHERE jmeno='$jmeno'";
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

            // Zaměněno za switch 

            // if ($row['role'] == 'admin') {
            //     header("Location: casopis.php");
            // } else {
            //     header("Location: casopis.php");
            // }

            switch ($row['role']) {
                case 'admin':
                    header("Location: admin.php");
                    break;
                case 'autor':
                    header("Location: autor.php");
                    break;
                case 'redaktor':
                    header("Location: redaktor.php");
                    break;
                case 'recenzent':
                    header("Location: recenzent.php");
                    break;
                case 'ctenar':
                    header("Location: ctenar.php");
                    break;
                default:
                    // Defaultní přesměrování pro neznámé role
                    header("Location: casopis.php");
                    break;
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