<?php
require_once 'db_connection.php';

function getVilleId($conn, $nom_ville) {
    // Recherche l'ID de la ville dans la table
    $query = "SELECT id_ville FROM ville WHERE nom_ville = :nom_ville";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nom_ville', $nom_ville);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si la ville existe, retourne son ID, sinon insère la ville et retourne son nouvel ID
    if ($row) {
        return $row['id_ville'];
    } else {
        $query_insert = "INSERT INTO ville (nom_ville) VALUES (:nom_ville)";
        $stmt_insert = $conn->prepare($query_insert);
        $stmt_insert->bindParam(':nom_ville', $nom_ville);
        $stmt_insert->execute();

        // Retourne l'ID de la nouvelle ville
        return $conn->lastInsertId();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            // Récupérer les valeurs pour le trajet
            $instant_depart = isset($_POST['instant_depart']) ? $_POST['instant_depart'] : '';
            $frais_par_passager = isset($_POST['frais_par_passager']) ? $_POST['frais_par_passager'] : '';
            $conducteur = isset($_POST['conducteur']) ? $_POST['conducteur'] : '';
            $id_voiture = isset($_POST['id_voiture']) ? $_POST['id_voiture'] : '';

            // Récupérer les valeurs pour l'étape
            $duree = isset($_POST['duree']) ? $_POST['duree'] : '';
            $distance = isset($_POST['distance']) ? $_POST['distance'] : '';
            $ville_depart = isset($_POST['ville_depart']) ? $_POST['ville_depart'] : '';
            $ville_arrivee = isset($_POST['ville_arrivee']) ? $_POST['ville_arrivee'] : '';



            // Vérifier si les valeurs sont non vides
            if (!empty($instant_depart) && !empty($frais_par_passager) && !empty($conducteur) && !empty($id_voiture) && !empty($duree) && !empty($distance) && !empty($ville_depart) && !empty($ville_arrivee)) {
                
                $conn->beginTransaction();

                try{

                    // Obtient les IDs des villes de départ et d'arrivée
                    $id_ville_depart = getVilleId($conn, $ville_depart);
                    $id_ville_arrivee = getVilleId($conn, $ville_arrivee);


                    // Préparer la requête d'insertion
                    $query_trajet = "INSERT INTO trajet (instant_depart, frais_par_passager, conducteur, id_voiture) VALUES (:instant_depart, :frais_par_passager, :conducteur, :id_voiture);";
                    $stmt_trajet = $conn->prepare($query_trajet);

                    // Liens des paramètres pour le trajet
                    $stmt_trajet->bindParam(':instant_depart', $instant_depart);
                    $stmt_trajet->bindParam(':frais_par_passager', $frais_par_passager);
                    $stmt_trajet->bindParam(':conducteur', $conducteur);
                    $stmt_trajet->bindParam(':id_voiture', $id_voiture);

                     // Exécuter la requête pour le trajet
                     $stmt_trajet->execute();

                     // Récupérer l'id_trajet généré
                    $id_trajet = $conn->lastInsertId();


                    // Préparer la requête d'insertion pour l'étape
                    $query_etape = "INSERT INTO etape (duree, distance, id_trajet, ville_depart, ville_arrivee) VALUES (:duree, :distance, :id_trajet, :ville_depart, :ville_arrivee)";
                    $stmt_etape = $conn->prepare($query_etape);

        
                    // Liens des paramètres pour l'étape
                    $stmt_etape->bindParam(':duree', $duree);
                    $stmt_etape->bindParam(':distance', $distance);
                    $stmt_etape->bindParam(':id_trajet', $id_trajet);
                    $stmt_etape->bindParam(':ville_depart', $id_ville_depart);
                    $stmt_etape->bindParam(':ville_arrivee', $_d_ville_arrivee);

                    // Exécuter la requête pour l'étape
                    $stmt_etape->execute();

                    // Valider la transaction
                    $conn->commit();

                echo "Le trajet et l'étape ont été insérés avec succès";
            } catch (PDOException $e) {
                // En cas d'erreur, annuler la transaction
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
?>
