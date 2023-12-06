<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covoiturage</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/_nav.php'; ?>
    </header>
    <main>
        <label for="filter">Filtrer par nom/prénom :</label>
        <input type="text" id="filter" name="filter">

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