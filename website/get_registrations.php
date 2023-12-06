<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $filterName = isset($_GET['filterName']) ? $_GET['filterName'] : '';

        $query = "SELECT i.*, t.id_trajet , e.prenom_etudiant, e.nom_etudiant, vi1.nom_ville AS depart from inscription i
                  INNER JOIN trajet t ON t.id_trajet = i.id_trajet
                  INNER JOIN etudiant e ON i.id_etudiant = e.id_etudiant
                  INNER JOIN ville vi1 ON i.id_ville = vi1.id_ville
                  WHERE 1=1";

        if (!empty($filterName)) {
            $query .= " AND (LOWER(e.nom_etudiant) LIKE :name OR LOWER(e.prenom_etudiant) LIKE :name)";
        }

        $stmt = $conn->prepare($query);

        if (!empty($filterName)) {
            $stmt->bindValue(':name', '%' . strtolower($filterName) . '%');
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<table><tr>";
            foreach (["Identifiant du trajet", "Nom du passager", "Prénom du passager", "Point de rendez-vous", "Destination"] as $t) {
                echo "<th>" . $t . "</th>";
            }
            echo "</tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach (["id_trajet", "nom_etudiant", "prenom_etudiant", "depart"] as $e) {
                    echo "<td>" . $row[$e] . "</td>";
                }
            
                $identifiant_trajet = $row['id_trajet'];
            
                $query2 = "SELECT v.nom_ville AS destination
                           FROM etape e
                           JOIN ville v ON e.ville_arrivee = v.id_ville
                           WHERE e.id_trajet = :identifiant_trajet
                           ORDER BY e.id_etape DESC
                           LIMIT 1";
            
                $stmt2 = $conn->prepare($query2);
                $stmt2->bindValue(':identifiant_trajet', $identifiant_trajet);
                $stmt2->execute();
            
                echo "<td>";
                while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                    echo $row2["destination"] . " ";
                }
                echo "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "Aucun résultat trouvé.";
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
