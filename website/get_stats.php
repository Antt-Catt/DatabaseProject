<?php
require_once 'db_connection.php';

try {
    $conn = connectDB();

    if ($conn) {
        $filter = isset($_GET['filter']) ? strtolower($_GET['filter']) : '';
        $query1 = "SELECT AVG(nb_passagers) AS moyenne_passagers FROM ( SELECT t.id_trajet, COUNT(i.id_etudiant) AS nb_passagers FROM trajet t LEFT JOIN inscription i ON t.id_trajet = i.id_trajet GROUP BY t.id_trajet ) AS passagers_par_trajet;";
        $query2 = "SELECT DATE(t.instant_depart) AS jour, AVG(e.distance) AS moyenne_distances_par_jour FROM trajet t JOIN etape e ON t.id_trajet = e.id_trajet GROUP BY DATE(t.instant_depart);";
        $query3 = "SELECT e.nom_etudiant || ' ' || e.prenom_etudiant AS conducteur, AVG(a.note) AS moyenne_avis FROM etudiant e JOIN trajet t ON e.id_etudiant = t.conducteur LEFT JOIN avis a ON t.id_trajet = a.id_trajet WHERE a.destinataire = e.id_etudiant GROUP BY e.id_etudiant ORDER BY moyenne_avis DESC;";
        $query4 = "SELECT e.nom_etudiant || ' ' || e.prenom_etudiant AS passager, AVG(a.note) AS moyenne_avis FROM etudiant e JOIN inscription i ON e.id_etudiant = i.id_etudiant LEFT JOIN avis a ON i.id_trajet = a.id_trajet WHERE a.destinataire = e.id_etudiant GROUP BY e.id_etudiant ORDER BY moyenne_avis DESC;";
        $result1 = $conn->query($query1);
        $result2 = $conn->query($query2);
        $result3 = $conn->query($query3);
        $result4 = $conn->query($query4);

        if ($result1->rowCount() > 0) {
            while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
                echo "<p>Moyenne des passagers sur l'ensemble des trajets effectués : " . $row['moyenne_passagers'] . "</p>";
            }
            echo "</table>";
        }
        if ($result2->rowCount() > 0) {
            echo "<p>Moyenne des distances parcourues en covoiturage par jour : </p><table><th>Jour</th><th>Moyenne de distance (en km)</th>";
            while ($row = $result2->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $row['jour'] . "</td><td>" . round($row['moyenne_distances_par_jour'], 2) . "</td></tr>";
            }
            echo "</table>";
        }
        if ($result3->rowCount() > 0) {
            echo "<p>Classement des meilleurs conducteurs d'après les avis : </p><table><th>Conducteur</th><th>Moyenne des avis</th>";
            while ($row = $result3->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $row['conducteur'] . "</td><td>" . round($row['moyenne_avis'], 2) . "</td></tr>";
            }
            echo "</table>";
        }
        if ($result4->rowCount() > 0) {
            echo "<p>Classement des meilleurs passagers d'après les avis : </p><table><th>Passagers</th><th>Moyenne des avis</th>";
            while ($row = $result4->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . $row['passager'] . "</td><td>" . round($row['moyenne_avis'], 2) . "</td></tr>";
            }
            echo "</table>";
        }
    }
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
