<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
            $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';

            if (!empty($nom) && !empty($prenom)) {
                $query = "INSERT INTO etudiant (nom_etudiant, prenom_etudiant) VALUES (:nom, :prenom);";
                $stmt = $conn->prepare($query);

                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);

                if ($stmt->execute()) {
                    header("Location: students.php");
                } else {
                    echo "Erreur lors de l'insertion de l'étudiant.";
                }
            } else {
                echo "Veuillez fournir un nom et un prénom.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
?>
