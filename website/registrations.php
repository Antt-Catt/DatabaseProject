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
        <form method="POST" action="insert_registrations.php">
            <label for="id_etudiant">Identifiant de l'étudiant :</label>
            <input type="text" id="id_etudiant" name="id_etudiant" required>
            <br>
            <label for="id_trajet">Identifiant du trajet :</label>
            <input type="text" id="id_trajet" name="id_trajet" required>
            <br>
            <label for="ville">Ville de l'étudiant :</label>
            <input type="text" id="ville" name="ville" required>
            <br>
            <input type="submit" value="Ajouter une inscription">
        </form>

        <form method="POST" action="accept_registrations.php">
            <label for="id_etudiant">Identifiant de l'étudiant :</label>
            <input type="text" id="id_etudiant" name="id_etudiant" required>
            <br>
            <label for="id_trajet">Identifiant du trajet :</label>
            <input type="text" id="id_trajet" name="id_trajet" required>
            <br>
            <label for="ville">Ville de l'étudiant :</label>
            <input type="text" id="ville" name="ville" required>
            <br>
            <input type="submit" value="Accepter une inscription">
        </form>

        <div>
            <label for="filterName">Filtrer par nom/prénom :</label>
            <input type="text" id="filterName" name="filterName">
        </div>

        <div id="registrationsList"></div>

        <script>
            $(document).ready(function() {
                function getTrajets(filterName = '') {
                    $.ajax({
                        url: 'get_registrations.php',
                        method: 'GET',
                        data: {
                            filterName: filterName
                        },
                        success: function(response) {
                            $('#registrationsList').html(response);
                        }
                    });
                }

                getTrajets();

                $('#filterName').on('input', function() {
                    getTrajets($(this).val().toLowerCase());
                });
            });
        </script>
    </main>
</body>

</html>