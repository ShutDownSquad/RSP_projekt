
<?php
session_start();

if (!isset($_SESSION['ID'])) {
    header("Location: index.html");
    exit();
}

require 'connect.php';
require_once('ratings.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

    <script src="https://kit.fontawesome.com/13529e2a7d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css" />
    <style>
/*================================================FOOTER==========================================================*/

footer{
        font-family: Arial, sans-serif;
        background-color: #95baaf;
        font-size: 14px;
        color: black;
        padding-top: 50px;
        width: 100%;
    }
    footer a {
        text-decoration: none;
        cursor: pointer;
    }
    .container{
        width: 1140px;
        margin: auto;
        display: flex;
        justify-content: center;
    }
    .footer-content{
        width: 33.3%;
        text-align:left;
    }

    .footer-content-kontakt {
        width: 45.3%;
        text-align:left;
    }

    h3{
        font-weight: bold;
        font-size: 20px;
        margin-bottom: 15px;
        text-align: left;
    }
    .footer-content p{
        width:230px;
        margin: auto;
        padding: 3px;
    }
    .footer-content ul{
        text-align: left;
    }
    .footer-content li a {
        text-decoration:none;
    }
    .list{
        padding: 0;
    }
    .list li{
        text-decoration:none;
        width: auto;
        text-align: left;
        list-style-type:none;
        padding: 7px;
        position: relative;
    }


    .list li::before{
        content: '';
        position: absolute;
        transform: translate(-50%,-50%);
        left: 13%;
        top: 100%;
        width: 0;
        height: 2px;
        background: #58ac54;
        transition-duration: .5s;
    }
    .list li:hover::before{
        width: 70px;
    }
    .social-icons{
        text-align: center;
        padding: 0;
    }
    .social-icons li{
        display: inline-block;
        text-align: center;
        padding: 5px;
    }
    .social-icons i{
        color: white;
        font-size: 25px;
    }
    a{
        text-decoration: none;
    }
    a:hover{
        color: #58ac54;
    }
    .social-icons i:hover{
        color: #58ac54;
    }

    .odkaz {
        text-decoration: none;
        color: black;
    }
/*==================================================================================================================*/


    table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            border-color: black;
        }

        th, td {
            border: 1px solid;
            padding: 8px;
            text-align: left;
            border-color: black;
            background-color: white;
        }

        th {
            background-color: #aeccc6;
            border-color: black;

        }

        #ad-container {
            text-align: center;
        }

        #ad {
            display: inline-block;
            margin: 20px;
            margin-top: 40px;
            padding: 10px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
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
          margin-bottom: 40px;
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
        }

        #logo {
            max-width: 130px;
            max-height: 130px;
            background-size: cover;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        #user-info {
            max-width: 250px;
            display: flex;
            z-index: 12;
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
    
            .button-chat {
          background-color: white;
          padding: 10px 15px;
          color: black;
          border: 1px solid black;
          border-radius: 4px;
          cursor: pointer;
          text-align: center;
          text-decoration: none;
        }

        .button-chat a {
            text-decoration: none;
            color: black;
        }

        .button-chat:hover {
            background-color: white;
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
            <div class="chat-button"><button class="button-chat"><a href="chat.php">Chatovací fórum</a></button></div>
            <img id="user-icon" src="<?php echo $user_image_path; ?>" alt="User Avatar" style="width: 30px; height: 30px; margin-left: 10px; cursor: pointer; border-radius: 100px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        </div>

        <!-- Modalové okno s informacemi o uživateli -->
        <div id="user-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div style="background: #fff; padding: 20px; max-width: 400px; margin: 50px auto; border-radius: 10px; background-color: #aeccc6; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <p>Jméno: <?php echo $_SESSION['jmeno']; ?></p>
                <p>Role: <?php echo $_SESSION['role']; ?></p>
                <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor'): ?>
                <a href="pridaniclanku.php"><button class="button">Přidat článek</button></a>
                <?php endif; ?>
                <button class="button" onclick="logout()">Odhlásit</button>
            </div>
        </div>
    </header>

    <body onload="startTimer(); displayNextImage();">
        <div>
            <img id="img" style="height: autopx; width: 400px; margin-right:auto;margin-left:36%; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);" src="startpicture.jpg" />
        </div>
    </body>

    <script type="text/javascript">
        function displayNextImage() {
            x = (x === images.length - 1) ? 0 : x + 1;
            document.getElementById("img").src = images[x];
        }

        function displayPreviousImage() {
            x = (x <= 0) ? images.length - 1 : x - 1;
            document.getElementById("img").src = images[x];
        }

        function startTimer() {
            setInterval(displayNextImage, 3000);
        }

        var images = [], x = -1;
        images[0] = "image1.jpg";
        images[1] = "image2.jpg";
        images[2] = "image3.jpg";
        images[2] = "image4.jpg";

        function logout() {
            window.location.href = 'index.html';
        }
    </script>

    <script src="script.js"></script>
    </div>
    <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent'): ?>        
    <?php endif; ?>

    <table>
        <thead>
            <tr>
            <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent'): ?>
                <th class="sort">Název článku <span class="icon-arrow">&UpArrow;</span></th>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent'): ?>
                <th class="sort">Komentář <span class="icon-arrow">&UpArrow;</span></th>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'recenzent'): ?>
                <th class="sort">Hodnocení <span class="icon-arrow">&UpArrow;</span></th>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent'): ?>
                <th>Hodnocení hvězdy</th>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent'): ?>
                <th>Stáhnout</th>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent'): ?>
                <th>Přečíst recenze</th>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor'): ?>
                <th>Smazat</th>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor'): ?>
                <th>Upravit</th>
            <?php endif; ?>
            <?php if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'recenzent'): ?>
                <th>Napsat recenzi</th>
            <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM clanky";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                     if (isset($_SESSION['role'])) {
                        echo "<tr>";
                        if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent') {
                            echo "<td>" . $row["nazev"] . "</td>";
                        }
                        if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent') {
                            echo "<td>" . $row["komentar"] . "</td>";
                        }
                        if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent') {
                            echo "<td><a href='hodnoceni.php?id=" . $row["id_clanku"] . "'>Ohodnotit článek</a></td>";
                        }
                        echo "<td>";

                        if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent') {
                            if ($row["hodnoceni"] !== null) {
                                $rating = $row["hodnoceni"];
                                for ($i = 0; $i < $rating; $i++) {
                                    echo '★';
                                }
                            } else {
                                echo "Žádné hodnocení";
                            }
                        }
                        echo "</td>";
                        if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent') {
                            echo "<td><a href='stahnoutclanek.php?id=" . $row["id_clanku"] . "'>Stáhnout</a></td>";
                        }
                        if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'uzivatel' || $_SESSION['role'] === 'recenzent') {
                            echo "<td><a href='precistrecenze.php?id=" . $row["id_clanku"] . "'>Přečíst recenze</a></td>";
                        }
                        if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor') {
                            echo '<td><a href="smazat.php?id=' . $row['id_clanku'] . '">Smazat</a></td>';
                        }
                        if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor') {
                            echo '<td><a href="upravaClanku.php?id=' . $row['id_clanku'] . '">Upravit</a></td>';
                        }
                        if ($_SESSION['role'] === 'autor' || $_SESSION['role'] === 'redaktor' || $_SESSION['role'] === 'recenzent') {
                            echo '<td><a href="recenze.php?id=' . $row['id_clanku'] . '">Napsat recenzi</a></td>';
                        }
                        echo "</tr>";
                     }
                }
            } else {
                echo "<tr><td colspan='6'>Žádné články k zobrazení</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    
    <footer>
        <div class="container">
            <div class="footer-content-kontakt">
                <h3>Kontaktujte Nás</h3>
                <p><i class="fa-solid fa-envelope"></i> Email: rspHelpdesk@gmail.com</p>
                <p><i class="fa-solid fa-phone-square-alt"></i> Telefon: +420 605 420 123</p>
                <p><i class="fa-solid fa-building"></i> Adresa: Tolstého 1556, Jihlava</p>
            </div>
            <div class="footer-content">
                <h3>Odkazy</h3>
                 <ul class="list">
                    <li><a class="odkaz" href="#">Domů</a></li>
                    <li><a class="odkaz" href="./helpdeskform/helpdesk.html">Kontaktní Formulář</a></li>
                 </ul>
            </div>
            <div class="footer-content">
                <h3>Sledujte Nás</h3>
                <ul class="social-icons">
                 <li><a href=""><i class="fab fa-facebook"></i></a></li>
                 <li><a href=""><i class="fab fa-twitter"></i></a></li>
                 <li><a href=""><i class="fab fa-instagram"></i></a></li>
                 <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        const table_headings = document.querySelectorAll(".sort"),
        table_rows = document.querySelectorAll('tbody tr');

        table_headings.forEach((head, i) => {
            let sort_arc = true;
            head.onclick = () => {
                table_headings.forEach(head => head.classList.remove('active'));
                head.classList.add('active');

                document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
                table_rows.forEach(row => {
                    (row.querySelectorAll('td')[i].classList.add('active'))
                });

                head.classList.toggle('asc', sort_arc);
                sort_arc = head.classList.contains('asc') ? false : true;

                sortTable(i, sort_arc);
            }
        });

        function sortTable(column, sort_arc) {
            [...table_rows].sort((a, b) => {
                let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
                    second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

                return sort_arc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
            }).map(sorted_row => document.querySelector('tbody').appendChild(sorted_row));
        }

        var modal = document.getElementById('user-modal');
        var icon = document.getElementById('user-icon');

        icon.onclick = function() {
            modal.style.display = "block";
            userAvatarModal.src = "<?php echo $default; ?>";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>    
</body>
</html>
