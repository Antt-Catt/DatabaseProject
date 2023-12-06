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
        
        <form method="POST" action="insert_students.php" id="addStudentForm">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            <br>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
            <br>
            <input type="submit" value="Ajouter étudiant">
        </form>

        <form method="POST" action="remove_students.php" id="removeStudentForm">
            <label for="id_etudiant">ID de l'étudiant à supprimer :</label>
            <input type="text" id="id_etudiant" name="id_etudiant" required>
            
            <input type="submit" value="Supprimer étudiant">
        </form>
        
        <h3>Rôle par étudiant</h3>
        
        <div>
            <label for="id_student">Indentifiant de l'étudiant (Pour informations détaillés) :</label>
            <input type="text" id="id_student" name="id_student">
        </div>
        
        <div id="studentInfos"></div>
        
        <h3>Liste des étudiants</h3>

        <div>
            <label for="filter">Filtrer par nom/prénom :</label>
            <input type="text" id="filter" name="filter">
        </div>

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
                
                function getInfosStudents(id_student = '') {
                    $.ajax({
                        url: 'get_infos_students.php',
                        method: 'GET',
                        data: {
                            id_student: id_student
                        },
                        success: function(response) {
                            $('#studentInfos').html(response);
                        }
                    });
                }

                getStudents();

                $('#filter').on('input', function() {
                    getStudents($(this).val().toLowerCase());
                });

                $('#id_student').on('input', function() {
                    getInfosStudents($(this).val());
                });
            });
        </script>
    </main>
</body>

</html>