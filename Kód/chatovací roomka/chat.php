<?php
// Připojení k databázi
require 'connect.php';
session_start();

// Funkce pro zobrazení zpráv
function zobrazZpravy() {
    global $spojeni;

    $sql = "SELECT zpravy.obsah, uzivatel.jmeno, uzivatel.role, zpravy.cas FROM zpravy
            JOIN uzivatel ON zpravy.uzivatel_id = uzivatel.id
            ORDER BY zpravy.cas DESC
            ";

    $result = $spojeni->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //$messageClass = (isset($row['uzivatel_id']) && $row['uzivatel_id'] == $_SESSION['ID']) ? 'user-message' : 'other-message';
            echo "<p><strong>" . $row['jmeno'] . ":</strong> " . $row['obsah'] . " <small>"  . "</small></p>";
            echo "<p>". $row['cas']."</p>";
        }
    } else {
        echo "No messages yet.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #chat-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow-y: scroll;
            max-height: 400px;
            background: white;
        }

        .user-message {
            background-color: #b3e0ff;
        }

        .other-message {
            background-color: #ffdb4d;
        }

        /* Formulář pro odeslání zprávy */
        #message-form {
            margin-top: 10px;
        }

        #message-input {
            width: 70%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        #send-button {
            padding: 5px;
            border: 1px solid #4CAF50;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        #send-button:hover {
            background-color: #45a049;
        }
        #chat{
            position: fixed;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        body{
            background: #ADD8E6;
        }
        #button{
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div id="chat">
    <!-- Zobrazení chatu -->
    <div id="chat-container">
        <?php
        // Zobrazení zpráv
        zobrazZpravy();
        ?>
    </div>

    <!-- Formulář pro odeslání zprávy -->
    <form id="message-form" method="post" action="odeslat_zpravu.php">
        <input id="message-input" type="text" name="zprava" placeholder="Napište zprávu" required>
        <button id="send-button" type="submit" name="odeslat">Odeslat</button>
    </form>
    </div>
    <button id="button" onclick="window.location.href='casopis.php'">zpět na články</button>
</body>
</html>
