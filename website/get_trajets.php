<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $filterCity = isset($_GET['filterCity']) ? $_GET['filterCity'] : '';
        $filterDate = isset($_GET['filterDate']) ? $_GET['filterDate'] : '';

        $query = "SELECT vo.type, et.nom_etudiant, et.prenom_etudiant, t.frais_par_passager, t.instant_depart, vi_depart.nom_ville AS nom_ville_depart, vi_arrivee.nom_ville AS nom_ville_arrivee, e.duree
        
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
            $titles = ["Type", "Nom du conducteur", "Prénom du conducteur", "Frais par passager", "Instant du départ", "Ville de départ", "Ville d'arrivée", "Duree"];

            echo "<tr>";
            foreach ($titles as $t) {
                echo "<th>" . $t . "</th>";
            }
            echo "</tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $elements = ["type", "nom_etudiant", "prenom_etudiant", "frais_par_passager", "instant_depart", "nom_ville_depart", "nom_ville_arrivee", "duree"];

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
