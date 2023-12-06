<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {

        $filterType = isset($_GET['filterType']) ? $_GET['filterType'] : '';
        $filterName = isset($_GET['filterName']) ? $_GET['filterName'] : '';

        $query = "SELECT vo.id_voiture, vo.type, vo.couleur, et.nom_etudiant, et.prenom_etudiant
                  FROM voiture vo
                  INNER JOIN etudiant et ON vo.conducteur = et.id_etudiant
                  WHERE 1 = 1";


        if (!empty($filterType)) {
            $query .= " AND LOWER(vo.type) LIKE :type";
        }

        if (!empty($filterName)) {
            $query .= " AND LOWER(et.nom_etudiant) LIKE :name OR LOWER(et.prenom_etudiant) LIKE :name";
        }

        $stmt = $conn->prepare($query);

        if (!empty($filterType)) {
            $stmt->bindValue(':type', '%' . strtolower($filterType) . '%');
        }

        if (!empty($filterName)) {
            $stmt->bindValue(':name', '%' . strtolower($filterName) . '%');
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            echo "<table><tr>";
            foreach (["Identifiant", "Type", "Couleur", "Nom du conducteur", "Prénom du conducteur"] as $t) {
                echo "<th>" . $t . "</th>";
            }
            echo "</tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $elements = ["id_voiture", "type", "couleur", "nom_etudiant", "prenom_etudiant"];

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
