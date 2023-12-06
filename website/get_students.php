<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $filter = isset($_GET['filter']) ? strtolower($_GET['filter']) : '';

        $query = "SELECT * FROM etudiant WHERE LOWER(nom_etudiant) LIKE :filter OR LOWER(prenom_etudiant) LIKE :filter";
        $stmt = $conn->prepare($query);

        $stmt->bindValue(':filter', '%' . $filter . '%', PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            echo "<table><th>Identifiant</th><th>Nom</th><th>Prénom</th>";
            foreach ($result as $row) {
                echo "<tr><td>" . $row['id_etudiant'] . "</td><td>" . $row['nom_etudiant'] . "</td><td>" . $row['prenom_etudiant'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun résultat trouvé.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
