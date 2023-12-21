
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

        #container {
          width: 400px;
          background-color: #aeccc6;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          margin: 20px auto;
          text-align: left;
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

        h1{
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="container">
        <form id="profileForm" method="post" action="Profil-tvorba.php" enctype="multipart/form-data">
            <h1>Vytvořte svůj profil</h1>
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="autor">Autor</option>
                <option value="redaktor">Redaktor</option>
                <option value="uzivatel">Uživatel</option>
                <option value="recenzent">Recenzent</option>
            </select>
            <label for="name">Jméno:</label>
            <input type="text" id="name" name="name" required>
            <label for="password">Heslo:</label>
            <input type="password" id="password" name="password" required>
            <label for="profileImage" style="margin-left: 10px ;">Obrázek:</label>
            <input type="file" id="profileImageInput" name="profileImage" accept="image/*" onchange="previewImage()">
            <img id="profileImage" src="#" alt="Profilový obrázek" style="display: none; margin-top: 10px;margin-bottom: 10px;  max-width:300px; height: auto;">
            <input type="submit" value="Vytvořit profil">
            <input type="button" value="Zpět" onclick="window.location.href='index.html'">
        </form>
    </div>

    <script>
    function previewImage() {
            var input = document.getElementById('profileImageInput');
            var preview = document.getElementById('profileImage');
            
            var file = input.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
