<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        #notifikace {
            width: 250px;
            height:250px;
            background-color: grey;
            color: white;
        }
    </style>

</head>
<body>
    <div id="notifikace">
    <?php include 'control.php'; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function() {
        // Funkce pro získání a zobrazení statusu
        function getStatus() {
            $.ajax({
                type: "GET",
                url: "display_status.php",
                dataType: "json", // Očekáváme JSON odpověď
                success: function(data) {
                    $("#notifikace").text("Status: " + data.status);
                },
                error: function() {
                    console.log("Chyba při získávání statusu.");
                }
            });
        }

    // Zavoláme funkci při načtení stránky
    getStatus();

    // Nastavíme periodické zjišťování statusu
    setInterval(function() {
        getStatus();
    }, 50000);
});

    </script>
</body>
</html>

