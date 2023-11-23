<?php
// Připojení k databázi - nahraďte správnými údaji
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "profilydatabaze";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Zpracování formuláře po odeslání
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získání hodnot z formuláře
    $role = $_POST["role"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $birthdate = $_POST["birthdate"];
    $bio = $_POST["bio"];

    // Zpracování obrázku
    $image_path = "";
    if ($_FILES["profileImage"]["error"] == 0) {
        $target_dir = ""; // sem je třeba vrazit adresu pro ukládání obrázku
        $target_file = $target_dir . basename($_FILES["profileImage"]["name"]);
        move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file);
        $image_path = $target_file;
    }

    // SQL dotaz pro vložení dat do tabulky
    $sql = "INSERT INTO profily (role, name, password, email, birthdate, bio, image_path)
            VALUES ('$role', '$name', '$password', '$email', '$birthdate', '$bio', '$image_path')";

    if ($conn->query($sql) === TRUE) {
       
        header("Location: menu.html"); //vrácení se na hlavní stránku po zaslání dat
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Uzavření připojení k databázi
$conn->close();
?>