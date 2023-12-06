<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            // Récupérer la valeur de l'ID de l'étudiant à supprimer
            $id_etudiant = isset($_POST['id_etudiant']) ? $_POST['id_etudiant'] : '';

            // Vérifier si l'ID de l'étudiant n'est pas vide
            if (!empty($id_etudiant)) {
                // Préparer la requête de suppression
                $query = "DELETE FROM etudiant WHERE id_etudiant = :id_etudiant;";
                $stmt = $conn->prepare($query);

                // Lier le paramètre
                $stmt->bindParam(':id_etudiant', $id_etudiant);

                // Exécuter la requête
                if ($stmt->execute()) {
                    header("Location: students.php");
                } else {
                    echo "Erreur lors de la suppression de l'étudiant.";
                }
            } else {
                echo "Veuillez fournir l'ID de l'étudiant à supprimer.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
?>
