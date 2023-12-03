<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covoiturage</title>
</head>

<body>
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/_nav.php'; ?>
    </header>
    <main>
        <?php
        require_once 'db_connection.php';

        try {
            $conn = connectDB();

            if ($conn) {
                $query = "SELECT * FROM etudiant";
                $result = $conn->query($query);

                if ($result->rowCount() > 0) {
                    echo "<table>";
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr><td>" . $row['nom_etudiant'] . "</td><td>" . $row['prenom_etudiant'] . "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "Aucun résultat trouvé.";
                }
            }
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
        ?>
    </main>
</body>

</html>