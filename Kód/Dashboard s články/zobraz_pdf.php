<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Články na hlavní stránce</title>
    <!-- Přidání Font Awesome pro hvězdný rating -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha384-Vn538j4+1dC4P1EG9us1Kpj32OpFAkFZJl3/JTQQSRg6z73fvaA6Z/hRTt8+pR6L" crossorigin="anonymous">
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

        .article-container {
            display: flex;
            border: 1px solid black;
            margin-bottom: 5px; /* Adjusted margin to reduce space */
            width: 80%;
            margin: auto;
        }

        .article-title,
        .article-text,
        .article-metadata,
        .article-rating,
        .article-links,
        .current-rating {
            border: 1px solid black;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        .article-rating {
            display: flex;
            align-items: center;
        }

        .article-metadata p {
            margin: 0;
        }

        .filter-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .filter-form select,
        .filter-form button {
            margin: 5px;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid black;
        }

        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            font-size: 20px;
        }

        .rating>span {
            display: inline-block;
            position: relative;
            width: 1.1em;
        }

        .rating>span:hover:before,
        .rating>span:hover~span:before {
            content: "\2605";
            position: absolute;
            color: gold;
        }

        .rating>span:before {
            content: "\2606";
            position: absolute;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        .action-buttons a {
            text-decoration: none;
            color: #fff;
            padding: 8px;
            margin: 5px;
            border-radius: 4px;
            cursor: pointer;
        }

        .review {
            background-color: #3498db;
        }

        .publish {
            background-color: #27ae60;
        }

        .archive {
            background-color: #e74c3c;
        }
    </style>
</head>

<body>

    <h1>Články na hlavní stránce</h1>

    <!-- Formulář pro filtrování a třídění -->
    <form class="filter-form" method="post" action="">
        <label for="filter">Filtr:</label>
        <select name="filter" id="filter">
            <option value="none">Bez filtru</option>
            <option value="title">Název</option>
            <option value="date">Datum</option>
            <option value="rating">Hodnocení</option>
        </select>

        <label for="sort">Třídění:</label>
        <select name="sort" id="sort">
            <option value="asc">Vzestupně</option>
            <option value="desc">Sestupně</option>
        </select>

        <button type="submit">Použít</button>
    </form>

    <?php
    include 'db_config.php';

    // Načtení článků z databáze s ohledem na filtry a třídění
    $filter = isset($_POST['filter']) ? $_POST['filter'] : 'none';
    $sort = isset($_POST['sort']) ? $_POST['sort'] : 'asc';

    $sql = "SELECT * FROM articles";

    switch ($filter) {
        case 'title':
            $sql .= " ORDER BY title $sort";
            break;
        case 'date':
            $sql .= " ORDER BY created_at $sort";
            break;
        case 'rating':
            $sql .= " ORDER BY rating $sort";
            break;
        default:
            break;
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Výpis článků
        while ($row = $result->fetch_assoc()) {
            echo '<div class="article-container">';

            // Nadpis článku
            echo '<div class="article-title">';
            echo '<h2>' . $row['title'] . '</h2>';
            echo '</div>';

            // Metadata článku (datum)
            echo '<div class="article-metadata">';
            echo '<p>Datum nahrání: ' . date("d.m.Y", strtotime($row['created_at'])) . '</p>';
            echo '</div>';

            // Aktuální hodnocení
            echo '<div class="current-rating" id="current-rating-' . $row['id'] . '">';
            echo '<p>Aktuální hodnocení: ' . $row['rating'] . '</p>';
            echo '</div>';

            // Odkaz na PDF soubor
            echo '<div class="article-links">';
            echo '<p><a href="' . $row['media_file'] . '" target="_blank">Zobraz PDF</a></p>';
            echo '</div>';

            // Text článku
            echo '<div class="article-text">';
            echo '<p>Recenze: ' . $row['text'] . '</p>';
            echo '</div>';

            // Rating
            echo '<div class="article-rating">';
            echo '<div class="rating" data-article-id="' . $row['id'] . '">';
            for ($i = 5; $i >= 1; $i--) {
                echo '<span data-rating="' . $i . '"></span>';
            }
            echo '</div>';
            echo '</div>';

            // Akční tlačítka
            echo '<div class="action-buttons">';
            echo '<a class="review" href="review.php?id=' . $row['id'] . '">Přidělit recenzi</a>';
            echo '<a class="publish" href="publish.php?id=' . $row['id'] . '">Publikovat</a>';
            echo '<a class="archive" href="archive.php?id=' . $row['id'] . '">Archivovat</a>';
            echo '</div>';

            echo '</div>';
        }
    } else {
        echo '<p>Žádné články k zobrazení.</p>';
    }

    $conn->close();
    ?>

    <!-- JavaScript pro odesílání hodnocení do databáze -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            // Nastavení hvězdného ratingu
            $('.rating > span').click(function () {
                var rating = $(this).data('rating');
                var articleId = $(this).parent().data('article-id');

                // AJAX volání pro odeslání hodnocení do databáze
                $.ajax({
                    url: 'update_read_status.php',
                    method: 'POST',
                    data: { article_id: articleId, rating: rating },
                    success: function (response) {
                        // Zde můžete provést další akce po úspěšném uložení hodnocení
                        console.log(response);
                    }
                });
            });
        });
    </script>

</body>

</html>
