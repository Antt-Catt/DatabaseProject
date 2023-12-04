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
        <div>
            <label for="filterCity">Filtrer par ville :</label>
            <input type="text" id="filterCity" name="filterCity">
            <br>
            <label for="filterDate">Filtrer par date :</label>
            <input type="date" id="filterDate" name="filterDate">
        </div>

        <div id="carsList"></div>

        <script>
            $(document).ready(function() {
                function getCars(filterCity = '', filterDate = '') {
                    $.ajax({
                        url: 'get_cars.php',
                        method: 'GET',
                        data: {
                            filterCity: filterCity,
                            filterDate: filterDate
                        },
                        success: function(response) {
                            $('#carsList').html(response);
                        }
                    });
                }

                getCars();

                $('#filterCity').on('input', function() {
                    getCars($(this).val().toLowerCase(), $('#filterDate').val());
                });

                $('#filterDate').on('change', function() {
                    getCars($('#filterCity').val().toLowerCase(), $(this).val());
                });
            });
        </script>
    </main>
</body>

</html>