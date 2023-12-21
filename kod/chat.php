<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: index.html");
    exit();
}

require 'connect.php';
//require_once('ratings.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Návrh UI pro přidávání článků do časopisu</title>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body {
          font-family: Arial, sans-serif;
          background-color: #bbe9db;
          margin: 0;
          padding: 0;
          display: flex;
          flex-direction: column;
          min-height: 100vh;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
          background-color: #95baaf;
          color: black;
          padding: 20px;
          display: flex;
          justify-content: space-between;
          align-items: center;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        nav {
          background-color: #aeccc6;
          display: flex;
          justify-content: space-around;
          padding: 10px;
          margin: 10px 20px;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #container {
          width: 400px;
          background-color: #aeccc6;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          margin: 20px auto;
          text-align: center;
        }

        label {
          display: block;
          margin-bottom: 8px;
          font-weight: bold;
        }

        input,
        select,
        textarea {
          width: 100%;
          padding: 8px;
          margin-bottom: 16px;
          box-sizing: border-box;
          border: 1px solid black;
          border-radius: 4px;
        }

        textarea {
          height: 100px;
          min-height: 100px;
          max-height: 200px;
          resize: vertical;
        }

        button {
          background-color: #4caf50;
          padding: 10px 15px;
          color: white;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          text-align: center;
          text-decoration: none;
        }

        button:hover {
          background-color: #45a049;
        }

        footer {
          background-color: #95baaf;
          color: black;
          padding: 10px;
          margin-top: auto;
          text-align: center;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #title {
            font-size: 40px;
            font-weight: bold;
            text-align: center;
        }

        #logo {
            max-width: 130px;
            max-height: 130px;
            background-size: cover;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        #user-info {
            max-width: 130px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            width: 80%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

            .close-btn:hover,
            .close-btn:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
    </style>
</head>
<body>
    <header>
        <img src="logo/logo_vspj.png" alt="Školní časopis logo" id="logo">
        <div id="title">Školní časopis VŠPJ </div>
        <div id="user-info">
            <?php
            $image_path_query = "SELECT image_path FROM uzivatel WHERE ID = " . $_SESSION['ID'];
            $image_path_result = $conn->query($image_path_query);

            if ($image_path_result->num_rows > 0) {
                $image_path_row = $image_path_result->fetch_assoc();
                if ($image_path_row['image_path'] != NULL) {
                    $user_image_path = $image_path_row['image_path'];
                } else {
                    // Default image path if no profile picture is set
                    $user_image_path = 'default_image.jpg';
                }
            } else {
                // Default image path if no profile picture is set
                $user_image_path = 'default_image.jpg';
            }
            ?>
            <img id="user-icon" src="<?php echo $user_image_path; ?>" alt="User Avatar" style="width: 30px; height: 30px; margin-left: 10px; cursor: pointer; border-radius: 100px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        </div>

        <!-- Modalové okno s informacemi o uživateli -->
        <div id="user-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="background: #fff; padding: 20px; max-width: 400px; margin: 50px auto; border-radius: 10px; background-color: #aeccc6; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <p>Jméno: <?php echo $_SESSION['jmeno']; ?></p>
                <p>Role: <?php echo $_SESSION['role']; ?></p>
                <button class="button" onclick="window.location.href='casopis.php'">Zpět</button>
                <button class="button" onclick="logout()">Odhlásit</button>
            </div>
        </div>
    </header>

    <div id="container">
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
    </div>

    <footer>&copy; 2023 Název | Kontaktní údaje</footer>

    <script>
        function logout() {
            window.location.href = 'index.html';
        }

        var modal = document.getElementById('user-modal');
        var icon = document.getElementById('user-icon');

        icon.onclick = function () {
            modal.style.display = "block";
            userAvatarModal.src = "<?php echo $image_path; ?>";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
