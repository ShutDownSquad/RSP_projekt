<?php
  function getRatingCount($articleID) {
  // Vytvořte SQL dotaz
  $sql = "SELECT COUNT(*) AS rating_count FROM hodnoceni WHERE id_clanku = ?";

  // Připravte dotaz
  $stmt = $conn->prepare($sql);

  // Připojte k dotazu ID článku
  $stmt->bind_param("i", $articleID);

  // Spusťte dotaz
  $stmt->execute();

  // Získejte výsledek dotazu
  $result = $stmt->get_result();

  // Vraťte počet hodnocení
  $row = $result->fetch_assoc();
  return $row['rating_count'];
}

function getRatingValue($articleID) {
  // Vytvořte SQL dotaz
  $sql = "SELECT SUM(hodnoteni_cislo) AS rating_value FROM hodnoceni WHERE id_clanku = ?";

  // Připravte dotaz
  $stmt = $conn->prepare($sql);

  // Připojte k dotazu ID článku
  $stmt->bind_param("i", $articleID);

  // Spusťte dotaz
  $stmt->execute();

  // Získejte výsledek dotazu
  $result = $stmt->get_result();

  // Vraťte celkovou hodnotu hodnocení
  $row = $result->fetch_assoc();
  return $row['rating_value'];
}
?>