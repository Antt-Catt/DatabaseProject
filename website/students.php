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
        <form method="GET" action="" id="filterForm">
            <label for="filter">Filtrer par nom/prénom :</label>
            <input type="text" id="filter" name="filter">
            <input type="submit" value="Filtrer">
        </form>

        <div id="studentList"></div>

        <script>
            $(document).ready(function() {
                function getStudents(filterValue = '') {
                    $.ajax({
                        url: 'get_students.php',
                        method: 'GET',
                        data: {
                            filter: filterValue
                        },
                        success: function(response) {
                            $('#studentList').html(response);
                        }
                    });
                }

                getStudents();

                $('#filter').on('input', function() {
                    var filterValue = $(this).val().toLowerCase();
                    getStudents(filterValue);
                });
            });
        </script>
    </main>
</body>

</html>