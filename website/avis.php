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
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/_nav.php'; ?>
    </header>
    <main>
        <form method="POST" action="insert_avis.php">
            <label for="id_trajet">Identifiant du trajet :</label>
            <input type="text" id="id_trajet" name="id_trajet" required>
            <br>
            <label for="auteur">Identifiant de l'auteur :</label>
            <input type="text" id="auteur" name="auteur" required>
            <br>
            <label for="destinataire">Identifiant du destinataire :</label>
            <input type="text" id="destinataire" name="destinataire" required>
            <br>
            <label for="note">Note :</label>
            <input type="number" id="note" name="note" required>
            <br>
            <label for="commentaire">Commentaire :</label>
            <input type="text" id="commentaire" name="commentaire">
            <br>
            <input type="submit" value="Ajouter un avis">
        </form>

        <div>
            <label for="filter">Filtrer par nom/prénom :</label>
            <input type="text" id="filter" name="filter">
        </div>

        <div id="avisList"></div>

        <script>
            $(document).ready(function() {
                function getAvis(filterValue = '') {
                    $.ajax({
                        url: 'get_avis.php',
                        method: 'GET',
                        data: {
                            filter: filterValue
                        },
                        success: function(response) {
                            $('#avisList').html(response);
                        }
                    });
                }

                getAvis();

                $('#filter').on('input', function() {
                    getAvis($(this).val().toLowerCase());
                });
            });
        </script>
    </main>
</body>

</html>