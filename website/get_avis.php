<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $filter = isset($_GET['filter']) ? strtolower($_GET['filter']) : '';
        $query = "SELECT a.*, CONCAT(au.nom_etudiant, ' ', au.prenom_etudiant) as auteur, CONCAT(de.nom_etudiant, ' ', de.prenom_etudiant) as destinataire
                  FROM avis a
                  INNER JOIN etudiant au ON a.auteur = au.id_etudiant
                  INNER JOIN etudiant de ON a.destinataire = de.id_etudiant
                  WHERE 1=1";

        if (!empty($filter)) {
            $query .= " AND (LOWER(au.nom_etudiant) LIKE :name OR LOWER(au.prenom_etudiant) LIKE :name OR LOWER(de.nom_etudiant) LIKE :name OR LOWER(de.prenom_etudiant) LIKE :name)";
        }

        $stmt = $conn->prepare($query);

        if (!empty($filter)) {
            $stmt->bindValue(':name', '%' . strtolower($filter) . '%');
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            echo "<table>";

            echo "<tr>";
            foreach (["Identifiant du trajet", "Auteur", "Destinataire", "Note", "Commentaire"] as $t) {
                echo "<th>" . $t . "</th>";
            }
            echo "</tr>";

            foreach ($result as $row) {
                $elements = ["id_trajet", "auteur", "destinataire", "note", "commentaire"];

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
