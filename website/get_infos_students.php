<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $id_student = isset($_GET['id_student']) ? strtolower($_GET['id_student']) : '';

        if (!empty($id_student)) {
            $query = "SELECT 'Conducteur' AS role, DATE(t.instant_depart) as date_depart, vd.nom_ville AS ville_depart, va.nom_ville AS ville_arrivee, t.frais_par_passager
                      FROM  trajet t
                      JOIN etape e ON t.id_trajet = e.id_trajet
                      JOIN ville vd ON e.ville_depart = vd.id_ville
                      JOIN ville va ON e.ville_arrivee = va.id_ville
                      WHERE t.conducteur = :id
                      UNION
                      SELECT 'Passager' AS role, DATE(t.instant_depart) as date_depart, vd.nom_ville AS ville_depart, va.nom_ville AS ville_arrivee, t.frais_par_passager
                      FROM trajet t
                      JOIN inscription i ON t.id_trajet = i.id_trajet
                      JOIN etape e ON t.id_trajet = e.id_trajet
                      JOIN ville vd ON e.ville_depart = vd.id_ville
                      JOIN ville va ON e.ville_arrivee = va.id_ville
                      WHERE i.id_etudiant = :id";
            $stmt = $conn->prepare($query);

            $stmt->bindParam(':id', $id_student);

            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                echo "<table><tr>";
                foreach (["Rôle", "Date de départ", "Ville de départ", "Ville d'arrivée", "Frais par passager"] as $t) {
                    echo "<th>" . $t . "</th>";
                }
                echo "</tr>";
                foreach ($result as $row) {
                    echo "<tr>";
                    foreach (["role", "date_depart", "ville_depart", "ville_arrivee", "frais_par_passager"] as $e) {
                        echo "<td>" . $row[$e] . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Aucun résultat trouvé.";
            }
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
