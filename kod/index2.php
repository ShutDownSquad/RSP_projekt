<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Návrh UI pro přidávání článků do časopisu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            background-color: #bbe9db;  
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #95baaf;
            color: black;
            padding: 10px;
            display: flex;
            justify-content: space-between;
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
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select, textarea {
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
        }
    </style>
</head>
<body>
    <header>
        <span>Znak VSPJ</span>
        <h1>Školní časopis VŠPJ</h1>
        <span>Jméno a role uživatele</span>
    </header>

    <nav>
        <!-- Zde přidat tlačítka v závislosti na přihlášené roli -->
        <button class="btn btn-success">Tlačítko 1</button>
        <button class="btn btn-success">Tlačítko 2</button>
        <button class="btn btn-success">Tlačítko 3</button>
    </nav>

    <form id="articleForm" enctype="multipart/form-data">
        <div id="container">
            <h2>Přidat Článek</h2>

            <!-- Kod k nahrazení: <input type="hidden" id="userRole" name="userRole" value="<?php echo $_SESSION['userRole']; ?>"> -->
            <input type="hidden" id="userRole" name="userRole" value="autor"> 

            <label for="articleTitle">Název článku:</label>
            <input type="text" id="articleTitle" name="articleTitle" required>

            <label for="mediaFile">Nahrání článku (PDF):</label>
            <input type="file" id="mediaFile" name="mediaFile" accept=".pdf" required>

            <label for="articleText">Komentář článku:</label>
            <textarea id="articleText" name="articleText" required></textarea>

            <label for="section">Sekce:</label>
            <select id="section" name="section" required>
                <option value="section1">Sekce 1</option>
                <option value="section2">Sekce 2</option>
                <option value="section3">Sekce 3</option>
            </select>

            <label for="tags">Tagy:</label>
            <input type="text" id="tags" name="tags" required>

            <button onclick="saveArticle()">Uložit</button>
        </div>
    </form>

    <footer>
        &copy; 2023 Název | Kontaktní údaje
    </footer>

    <script>
        function saveArticle() {
            // Získání hodnoty role přímo z formuláře. Nahradit kodem:
            // var userRole = document.getElementById('userRole').value;

            var userRole = "autor";

            // Ověření role. Lze přidat další role jak bude třeba
            if (userRole !== 'autor') {
                alert('Nemáte oprávnění přidávat články.');
                return;
            }

            var articleForm = document.getElementById('articleForm');
            var formData = new FormData(articleForm);

            if (articleTitle.trim() === '') {
                alert('Prosím, vyplňte název článku.');
                return;
            }

            var mediaFile = document.getElementById('mediaFile').files[0];
            formData.append('mediaFilePath', 'uploads/' + mediaFile.name);
    
            $.ajax({
                type: 'POST',
                url: 'save_article.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var result = JSON.parse(response);

                    if (result.status === 'success') {
                        // Úspěch - zobrazím potvrzení
                        alert('Článek byl úspěšně uložen.');
                    } else {
                        // Chyba - zobrazím chybovou zprávu
                        alert('Chyba: ' + result.message);
                    }
                },
                error: function() {
                    alert('Chyba při odesílání dat na server.');
                }
            });
        }
    </script>    
    
</body>
</html>