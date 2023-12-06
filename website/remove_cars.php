<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            $id_voiture = isset($_POST['id_voiture']) ? $_POST['id_voiture'] : '';

            if (!empty($id_voiture)) {
                $query = "DELETE FROM voiture WHERE id_voiture = :id_voiture;";
                $stmt = $conn->prepare($query);

                $stmt->bindParam(':id_voiture', $id_voiture);

                if ($stmt->execute()) {
                    header("Location: cars.php");
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
