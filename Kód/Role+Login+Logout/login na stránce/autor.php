<?php
session_start();

// Kontroluje roli uživatele
if (!isset($_SESSION['jmeno']) || $_SESSION['role'] !== 'autor') {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Školní časopis VŠPJ</title>
    <style>
        thead th span.icon-arrow {
	width: 1.3rem;
	height: 1.3rem;
	display: inline-block;
	 border: 1.4px solid transparent;
	border-radius: 50%;
	text-align: center;
	font: 1rem;
	margin-left: .5rem;
	transition: .2s ease-in-out;
}

.sort {
	cursor: pointer;
}

thead th.active,tbody td.active {
	color: #45a049;
}

thead th.active span.icon-arrow {
	border: 1.4px solid #45a049;
}

thead th.asc span.icon-arrow {
	transform: rotate(180deg);
}
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #f1f1f1;
            padding: 10px;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #logo {
            max-width: 100px;
            max-height: 100px;
            background-size: cover;
        }

        #title {
            font-size: 24px;
            font-weight: bold;
        }

        nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-bottom: 1px solid #ccc;
            background-color: #f9f9f9;
            padding: 10px;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #45a049;
        }

        #login-box {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #login-box input {
            margin-bottom: 10px;
        }

        #login-box button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        #login-box button:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        function toggleLoginBox() {
            var loginBox = document.getElementById('login-box');
            loginBox.style.display = (loginBox.style.display === 'none' || loginBox.style.display === '') ? 'block' : 'none';
        }
    </script>
</head>
<body>

    <header>
        <img src="logo/logo_vspj.png" alt="Školní časopis logo" id="logo">
        <div id="title">Školní časopis VŠPJ</div>
        <button onclick="toggleLoginBox()">Přihlásit se / Odhlásit</button>

        <div id="login-box">
            <?php
            if (isset($_SESSION['jmeno'])) {
                echo "<p>Hello, " . $_SESSION['jmeno'] . "!</p>";
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<h2>Přihlášení</h2>';
                echo '<form action="proces_prihlaseni.php" method="post">';
                echo '<label for="jmeno">Jméno:</label>';
                echo '<input type="text" id="jmeno" name="jmeno" required>';
            
                echo '<label for="heslo">Heslo:</label>';
                echo '<input type="password" id="heslo" name="heslo" required>';
            
                echo '<button type="submit">Přihlásit se</button>';
                echo '</form>';
                echo '<p>Nemáte účet? <a href="registrace.html">Registrovat se</a></p>';
            }
            ?>
        </div>
    </header>

    <nav>
        <button class="button">Domů</button>
        <button class="button">Komunikace</button>
        <button class="button">Nastavení účtu</button>
        <button class="button">Recenze</button>
        <div class="dropdown">
            <button class="button">Seřadit</button>
            <div class="dropdown-content">
                <a href="#">Podle vydání</a>
                <a href="#">Podle hodnocení</a>
                <a href="#">Podle jména</a>
            </div>
        </div>
    </nav>

    <a href="pridaniclanku.html">
        <button>Přidat článek</button>
    </a>

    <table>
        <thead>
            <tr>
            <th class="sort">Název článku <span class="icon-arrow">&UpArrow;</span></th>
                <th class="sort">Datum vydání <span class="icon-arrow">&UpArrow;</span></th>
                <th class="sort">Hodnocení <span class="icon-arrow">&UpArrow;</span></th>
                <th>Zobrazit</th>
                <th>Stáhnout</th>
                <th>Přečíst recenze</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require 'connect.php';

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM clanky";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nazev"] . "</td>";
                    echo "<td>" . $row["datum_vydani"] . "</td>";
                    echo "<td>" . $row["hodnoceni"] . "</td>";
                    echo "<td><a href='zobrazclanek.php?id=" . $row["id"] . "'>Zobrazit</a></td>";
                    echo "<td><a href='stahnoutclanek.php?id=" . $row["id"] . "'>Stáhnout</a></td>";
                    echo "<td><a href='precistrecenze.php?id=" . $row["id"] . "'>Přečíst recenze</a></td>";
                    
                    echo '<td><a href="smazat.php?id=' . $row['id_clanku'] . '">Smazat</a></td>';
                    echo '<td><a href="upravaClanku.html?id=' . $row['id_clanku'] . '">upravit</a></td>';
    
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Žádné články k zobrazení</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    <script>
    const table_headings = document.querySelectorAll(".sort"),
    table_rows = document.querySelectorAll('tbody tr');

    table_headings.forEach((head, i)=>{
        let sort_arc = true;
        head.onclick = () => {
            table_headings.forEach(head => head.classList.remove('active'));
            head.classList.add('active');

            document.querySelectorAll('td').forEach(td=> td.classList.remove('active'))
            table_rows.forEach(row=> {
                (row.querySelectorAll('td')[i].classList.add('active'))
            })

            head.classList.toggle('asc', sort_arc)
            sort_arc = head.classList.contains('asc') ? false : true;

            sortTable(i, sort_arc);
        }
    })

function sortTable(column, sort_arc) {
    [...table_rows].sort((a, b) => {
        let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
        second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

        return  sort_arc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
    }).map(sorted_row => document.querySelector('tbody').appendChild(sorted_row));
}
</script>    
</body>
</html>