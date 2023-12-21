<?php
$servername = "localhost";
$username = "kolar17";
$password = "Tis*8918298";
$dbname = "kolar17";

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

    // Zpracování obrázku
    $image_path = "";
    if ($_FILES["profileImage"]["error"] == 0) {
        $target_dir = "uploads/"; // Nastavit dle potřeby
        $target_file = $target_dir . basename($_FILES["profileImage"]["name"]);
        move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file);
        $image_path = $target_file;
    }

    // Hashování hesla - doporučuje se pro bezpečnost
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Připravený výraz pro vložení dat do tabulky
    $sql = $conn->prepare("INSERT INTO uzivatel (role, jmeno, heslo, image_path)
            VALUES (?, ?, ?, ?)");

    // Vazba parametrů
    $sql->bind_param("ssss", $role, $name, $hashed_password, $image_path);

    if ($sql->execute() === TRUE) {
        header("Location: index.html"); // Návrat na hlavní stránku po odeslání dat
        exit();
    } else {
        die("Error: " . $sql->error);
    }

    $sql->close();
}

// Uzavření připojení k databázi
$conn->close();
?>
