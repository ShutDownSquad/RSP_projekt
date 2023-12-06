<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rsp_casopis";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT status FROM clanek WHERE autor = :autor");
    $stmt->bindParam(':autor', $autor_value);

    // Nastavte hodnotu autora a dalšího ukazatele podle potřeby
    $autor_value = "jenda";

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        echo "<p>Status: " . htmlspecialchars($row["status"]) . "</p>";
    } else {
        echo "Nenalezen žádný článek s daným autorem a ukazatelem.";
    }
} catch (PDOException $e) {
    echo "Chyba při práci s databází: " . $e->getMessage();
}

$conn = null;
?>
