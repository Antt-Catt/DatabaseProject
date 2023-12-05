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
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/_nav.php'; ?>
    </header>
    <main>
        <div id="stats"></div>

        <script>
            $(document).ready(function() {
                function getCars(filterType = '') {
                    $.ajax({
                        url: 'get_stats.php',
                        method: 'GET',
                        success: function(response) {
                            $('#stats').html(response);
                        }
                    });
                }

                getCars();
            });
        </script>
    </main>
</body>

</html>