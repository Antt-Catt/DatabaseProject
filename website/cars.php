<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Covoiturage</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/_nav.php'; ?>
    </header>
    <main>
        <form method="POST" action="insert_cars.php" id="addCarForm">
        <label for="type">Type :</label>
            <input type="text" id="type" name="type" required>
            <br>
            <label for="couleur">Couleur :</label>
            <input type="text" id="couleur" name="couleur" required>
            <br>
            <label for="ndp">Nombre de places :</label>
            <input type="text" id="ndp" name="ndp" required>
            <br>
            <label for="etat">Etat :</label>
            <input type="text" id="etat" name="etat" required>
            <br>
            <label for="conducteur">Id du conducteur :</label>
            <input type="text" id="conducteur" name="conducteur" required>
            <br>
            <input type="submit" value="Ajouter vehicule">
        </form>

        <form method="POST" action="remove_cars.php" id="removeCarForm">
            <label for="id_voiture">ID de la voiture à supprimer :</label>
            <input type="text" id="id_voiture" name="id_voiture" required>
            <input type="submit" value="Supprimer voiture">
        </form>

        <div>
            <label for="filterType">Filtrer par Type :</label>
            <input type="text" id="filterType" name="filterType">
            <br>
            <label for="filterName">Filtrer par nom/prénom du conducteur :</label>
            <input type="text" id="filterName" name="filterName">
        </div>

        <div id="carsList"></div>

        <script>
            $(document).ready(function() {
                function getCars(filterType = '', filterName = '') {
                    $.ajax({
                        url: 'get_cars.php',
                        method: 'GET',
                        data: {
                            filterType: filterType,
                            filterName: filterName
                        },
                        success: function(response) {
                            $('#carsList').html(response);
                        }
                    });
                }

                getCars();

                $('#filterType').on('input', function() {
                    getCars($(this).val().toLowerCase(), $('#filterName').val().toLowerCase());
                });
                $('#filterName').on('input', function() {
                    getCars($('#filterType').val().toLowerCase(), $(this).val().toLowerCase());
                });
            });
        </script>
    </main>
</body>

</html>