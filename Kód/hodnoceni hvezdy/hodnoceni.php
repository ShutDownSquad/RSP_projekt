<!-- hodnoceni.php -->

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Hodnocení článku</title>
    <!-- Styly pro hvězdičkové hodnocení -->
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }
        .rating input {
            display: none;
        }
        .rating label {
            cursor: pointer;
            font-size: 2rem;
        }
        .rating label:before {
            content: '★';
        }
        .rating input:checked ~ label:before {
            color: orange;
        }
    </style>
</head>
<body>
    <h1>Hodnocení článku</h1>
    <form action="proces_hodnoceni.php" method="POST">
        <div class="rating">
            <!-- Umožní uživateli vybrat počet hvězdiček -->
            <input type="radio" id="star5" name="rating" value="5"><label for="star5"></label>
            <input type="radio" id="star4" name="rating" value="4"><label for="star4"></label>
            <input type="radio" id="star3" name="rating" value="3"><label for="star3"></label>
            <input type="radio" id="star2" name="rating" value="2"><label for="star2"></label>
            <input type="radio" id="star1" name="rating" value="1"><label for="star1"></label>
        </div>
        <input type="hidden" name="article_id" value="<?php echo $_GET['id']; ?>">
        <input type="submit" value="Odeslat hodnocení">
    </form>
</body>
</html>