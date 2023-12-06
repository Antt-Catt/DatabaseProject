<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            $id_etudiant = isset($_POST['id_etudiant']) ? $_POST['id_etudiant'] : '';

            if (!empty($id_etudiant)) {
                $query = "DELETE FROM etudiant WHERE id_etudiant = :id_etudiant;";
                $stmt = $conn->prepare($query);

                $stmt->bindParam(':id_etudiant', $id_etudiant);

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
