<?php
require_once 'db_connection.php';

function getVilleId($conn, $nom_ville)
{
    $query = "SELECT id_ville FROM ville WHERE nom_ville = :nom_ville;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nom_ville', $nom_ville);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return $row['id_ville'];
    } else {
        $query_insert = "INSERT INTO ville (nom_ville) VALUES (:nom_ville);";
        $stmt_insert = $conn->prepare($query_insert);
        $stmt_insert->bindParam(':nom_ville', $nom_ville);
        $stmt_insert->execute();

        return $conn->lastInsertId();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            // trajet
            $instant_depart = isset($_POST['instant_depart']) ? $_POST['instant_depart'] : '';
            $frais_par_passager = isset($_POST['frais_par_passager']) ? $_POST['frais_par_passager'] : '';
            $conducteur = isset($_POST['conducteur']) ? $_POST['conducteur'] : '';
            $id_voiture = isset($_POST['id_voiture']) ? $_POST['id_voiture'] : '';

            // étape
            $duree = isset($_POST['duree']) ? $_POST['duree'] : '';
            $distance = isset($_POST['distance']) ? $_POST['distance'] : '';
            $ville_depart = isset($_POST['ville_depart']) ? $_POST['ville_depart'] : '';
            $ville_arrivee = isset($_POST['ville_arrivee']) ? $_POST['ville_arrivee'] : '';

            if (!empty($instant_depart) && !empty($frais_par_passager) && !empty($conducteur) && !empty($id_voiture) && !empty($duree) && !empty($distance) && !empty($ville_depart) && !empty($ville_arrivee)) {

                $conn->beginTransaction();

                try {

                    $id_ville_depart = getVilleId($conn, $ville_depart);
                    $id_ville_arrivee = getVilleId($conn, $ville_arrivee);

                    $query_trajet = "INSERT INTO trajet (instant_depart, frais_par_passager, conducteur, id_voiture) VALUES (:instant_depart, :frais_par_passager, :conducteur, :id_voiture);";
                    $stmt_trajet = $conn->prepare($query_trajet);

                    $stmt_trajet->bindParam(':instant_depart', $instant_depart);
                    $stmt_trajet->bindParam(':frais_par_passager', $frais_par_passager);
                    $stmt_trajet->bindParam(':conducteur', $conducteur);
                    $stmt_trajet->bindParam(':id_voiture', $id_voiture);

                    $stmt_trajet->execute();

                    $id_trajet = $conn->lastInsertId();

                    $query_etape = "INSERT INTO etape (duree, distance, id_trajet, ville_depart, ville_arrivee) VALUES (:duree, :distance, :id_trajet, :ville_depart, :ville_arrivee)";
                    $stmt_etape = $conn->prepare($query_etape);

                    $stmt_etape->bindParam(':duree', $duree);
                    $stmt_etape->bindParam(':distance', $distance);
                    $stmt_etape->bindParam(':id_trajet', $id_trajet);
                    $stmt_etape->bindParam(':ville_depart', $id_ville_depart);
                    $stmt_etape->bindParam(':ville_arrivee', $id_ville_arrivee);

                    $stmt_etape->execute();

                    $conn->commit();

                    header("Location: trajets.php");
                } catch (PDOException $e) {
                    $conn->rollBack();
                    echo "Erreur lors de l'insertion du trajet et de l'étape: " . $e->getMessage();
                }
            } else {
                echo "Veuillez fournir toutes les informations nécessaires pour le trajet et l'étape.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
