<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $filterCity = isset($_GET['filterCity']) ? $_GET['filterCity'] : '';
        $filterDate1 = isset($_GET['filterDate1']) ? $_GET['filterDate1'] : '';
        $filterDate2 = isset($_GET['filterDate2']) ? $_GET['filterDate2'] : '';

        $query = "SELECT t.id_trajet, vo.type, et.nom_etudiant, et.prenom_etudiant, t.frais_par_passager, t.instant_depart, vi_depart.nom_ville AS nom_ville_depart, vi_arrivee.nom_ville AS nom_ville_arrivee, e.duree
                  FROM voiture vo
                  INNER JOIN trajet t ON vo.id_voiture = t.id_voiture
                  INNER JOIN etape e ON t.id_trajet = e.id_trajet
                  INNER JOIN ville vi_depart ON e.ville_depart = vi_depart.id_ville
                  INNER JOIN ville vi_arrivee ON e.ville_arrivee = vi_arrivee.id_ville
                  INNER JOIN etudiant et ON vo.conducteur = et.id_etudiant
                  WHERE 1 = 1";

        if (!empty($filterCity)) {
            $query .= " AND (LOWER(vi_depart.nom_ville) LIKE :city OR LOWER(vi_arrivee.nom_ville) LIKE :city)";
        }

        if (!empty($filterDate1)) {
            $formattedDate1 = date('Y-m-d', strtotime($filterDate1));
            $query .= " AND DATE_TRUNC('day', t.instant_depart)::DATE > :date1";
        }

        if (!empty($filterDate2)) {
            $formattedDate2 = date('Y-m-d', strtotime($filterDate2));
            $query .= " AND DATE_TRUNC('day', t.instant_depart)::DATE < :date2";
        }

        $stmt = $conn->prepare($query);

        if (!empty($filterCity)) {
            $stmt->bindValue(':city', '%' . strtolower($filterCity) . '%');
        }

        if (!empty($filterDate1)) {
            $stmt->bindValue(':date1', '%' . $formattedDate1 . '%');
        }

        if (!empty($filterDate2)) {
            $stmt->bindValue(':date2', '%' . $formattedDate2 . '%');
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<table><tr>";
            foreach (["Identifiant", "Type", "Nom du conducteur", "Prénom du conducteur", "Frais par passager", "Instant du départ", "Ville de départ", "Ville d'arrivée", "Duree"] as $t) {
                echo "<th>" . $t . "</th>";
            }
            echo "</tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $elements = ["id_trajet", "type", "nom_etudiant", "prenom_etudiant", "frais_par_passager", "instant_depart", "nom_ville_depart", "nom_ville_arrivee", "duree"];

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
