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
        <form method="POST" action="insert_trajets.php" id="addTrajetForm">
            <label for="instant_depart"> Instant depart :</label>
            <input type="datetime-local" id="type" name="instant_depart" required>
            <br>
            <label for="frais_par_passager">Frais par passager :</label>
            <input type="text" id="frais_par_passager" name="frais_par_passager" required>
            <br>
            <label for="conducteur">Id conducteur :</label>
            <input type="text" id="conducteur" name="conducteur" required>
            <br>
            <label for="id_voiture">Id voiture :</label>
            <input type="text" id="id_voiture" name="id_voiture" required>
            <br>
            <label for="duree">Durée du trajet:</label>
            <input type="text" id="duree" name="duree" required>
            <br>
            <label for="distance">Distance du trajet:</label>
            <input type="text" id="distance" name="distance" required>
            <br>
            <label for="ville_depart">Ville de départ du trajet:</label>
            <input type="text" id="ville_depart" name="ville_depart" required>
            <br>
            <label for="ville_arrivee">Ville d'arrivée du trajet:</label>
            <input type="text" id="ville_arrivee" name="ville_arrivee" required>
            <br>
            <input type="submit" value="Ajouter trajet">
        </form>
        
        <div>
            <label for="filterCity">Filtrer par ville :</label>
            <input type="text" id="filterCity" name="filterCity">
            <br>
            <label for="filterDate">Filtrer par date :</label>
            <input type="date" id="filterDate" name="filterDate">
        </div>

        <div id="trajetsList"></div>

        <script>
            $(document).ready(function() {
                function getTrajets(filterCity = '', filterDate = '') {
                    $.ajax({
                        url: 'get_trajets.php',
                        method: 'GET',
                        data: {
                            filterCity: filterCity,
                            filterDate: filterDate
                        },
                        success: function(response) {
                            $('#trajetsList').html(response);
                        }
                    });
                }

                getTrajets();

                $('#filterCity').on('input', function() {
                    getTrajets($(this).val().toLowerCase(), $('#filterDate').val());
                });

                $('#filterDate').on('change', function() {
                    getTrajets($('#filterCity').val().toLowerCase(), $(this).val());
                });

        
            });
        </script>
    </main>
</body>

</html>