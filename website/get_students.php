<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $filter = isset($_GET['filter']) ? strtolower($_GET['filter']) : '';
        $query = "SELECT * FROM etudiant WHERE LOWER(nom_etudiant) LIKE '%$filter%' OR LOWER(prenom_etudiant) LIKE '%$filter%'";
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
