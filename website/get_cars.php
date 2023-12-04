<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $filterCity = isset($_GET['filterCity']) ? $_GET['filterCity'] : '';
        $filterDate = isset($_GET['filterDate']) ? $_GET['filterDate'] : '';

        $query = "SELECT vo.*, et.*, t.*, vi_arrivee.nom_ville AS nom_ville_arrivee, vi_depart.nom_ville AS nom_ville_depart
                  FROM voiture vo
                  INNER JOIN trajet t ON vo.id_voiture = t.id_voiture
                  INNER JOIN etape e ON t.id_trajet = e.id_trajet
                  INNER JOIN ville vi_depart ON e.ville_depart = vi_depart.id_ville
                  INNER JOIN ville vi_arrivee ON e.ville_arrivee = vi_arrivee.id_ville
                  INNER JOIN etudiant et ON vo.conducteur = et.id_etudiant
                  WHERE 1 = 1";

        if (!empty($filterCity)) {
            $query .= " AND LOWER(vi_depart.nom_ville) LIKE :city";
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
            $titles = ["Type", "Couleur", "Nom du conducteur", "Prénom du conducteur", "Instant du départ", "Frais par passager", "Ville de départ", "Ville d'arrivée"];
            echo "<tr>";
            foreach ($titles as $t) {
                echo "<th>" . $t . "</th>";
            }
            echo "</tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $elements = ["type", "couleur", "nom_etudiant", "prenom_etudiant", "instant_depart", "frais_par_passager", "nom_ville_depart", "nom_ville_arrivee"];
                echo "<tr>";
                foreach ($elements as $e) {
                    echo "<td>" . $row[$e] . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun résultat trouvé.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
