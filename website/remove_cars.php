<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            // Récupérer la valeur de l'ID de la voiture à supprimer
            $id_voiture = isset($_POST['id_voiture']) ? $_POST['id_voiture'] : '';

            // Vérifier si l'ID de l'étudiant n'est pas vide
            if (!empty($id_voiture)) {
                // Préparer la requête de suppression
                $query = "DELETE FROM voiture WHERE id_voiture = :id_voiture;";
                $stmt = $conn->prepare($query);

                // Lier le paramètre
                $stmt->bindParam(':id_voiture', $id_voiture);

                // Exécuter la requête
                if ($stmt->execute()) {
                    echo "Voiture supprimée avec succès.";
                } else {
                    echo "Erreur lors de la suppression de la voiture.";
                }
            } else {
                echo "Veuillez fournir l'ID de la voiture à supprimer.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
?>
