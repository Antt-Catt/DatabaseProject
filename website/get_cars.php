<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $filterCity = isset($_GET['filterCity']) ? $_GET['filterCity'] : '';
        $filterDate = isset($_GET['filterDate']) ? $_GET['filterDate'] : '';

        var_dump($filterCity);
        var_dump($filterDate);

        $query = "SELECT vo.*
                  FROM voiture vo
                  INNER JOIN trajet t ON vo.id_voiture = t.id_voiture
                  INNER JOIN etape e ON t.id_trajet = e.id_trajet
                  INNER JOIN ville vi ON e.ville_depart = vi.id_ville
                  WHERE 1 = 1";


        if (!empty($filterCity)) {
            $query .= " AND LOWER(vi.nom_ville) LIKE :city";
        }
        
        if (!empty($filterDate)) {
            $formattedDate = date('Y-m-d', strtotime($filterDate));
            $query .= " AND DATE_TRUNC('day', t.instant_depart)::DATE = :date";
        }


        $stmt = $conn->prepare($query);

        if (!empty($filterCity)) {
            $stmt->bindValue(':city', '%' . strtolower($filterCity) . '%');
        }
        
        if (!empty($filterDate)) {
            $stmt->bindValue(':date', '%' . $formattedDate . '%');
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<table>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $row['id_voiture'] . "</td><td>" . $row['type'] . "</td><td>" . $row['couleur'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun résultat trouvé.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
