<?php
require_once 'db_connection.php';

function getVilleId($conn, $nom_ville)
{
    // Recherche l'ID de la ville dans la table
    $query = "SELECT id_ville FROM ville WHERE nom_ville = :nom_ville;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nom_ville', $nom_ville);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si la ville existe, retourne son ID, sinon insère la ville et retourne son nouvel ID
    if ($row) {
        return $row['id_ville'];
    } else {
        $query_insert = "INSERT INTO ville (nom_ville) VALUES (:nom_ville);";
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
            // Récupérer les valeurs pour l'inscription
            $id_etudiant = isset($_POST['id_etudiant']) ? $_POST['id_etudiant'] : '';
            $id_trajet = isset($_POST['id_trajet']) ? $_POST['id_trajet'] : '';
            $ville = isset($_POST['ville']) ? $_POST['ville'] : '';

            // Vérifier si les valeurs sont non vides
            if (!empty($id_etudiant) && !empty($id_trajet) && !empty($ville)) {

                $conn->beginTransaction();

                try {
                    // Obtient les IDs des villes de départ et d'arrivée
                    $id_ville = getVilleId($conn, $ville);

                    // Préparer la requête d'insertion
                    $query_trajet = "UPDATE inscription SET acceptation = TRUE WHERE id_etudiant = :id_etudiant AND id_trajet = :id_trajet AND id_ville = :id_ville;";
                    $stmt = $conn->prepare($query_trajet);

                    // Liens des paramètres pour l'inscription
                    $stmt->bindParam(':id_etudiant', $id_etudiant);
                    $stmt->bindParam(':id_trajet', $id_trajet);
                    $stmt->bindParam(':id_ville', $id_ville);

                    // Exécuter la requête
                    $stmt->execute();

                    // Valider la transaction
                    $conn->commit();

                    header("Location: registrations.php");
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
