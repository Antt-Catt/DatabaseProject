<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            // Récupérer les valeurs du formulaire
            $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
            $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';

            // Vérifier si les valeurs sont non vides
            if (!empty($nom) && !empty($prenom)) {
                // Préparer la requête d'insertion
                $query = "INSERT INTO etudiant (nom_etudiant, prenom_etudiant) VALUES (:nom, :prenom);";
                $stmt = $conn->prepare($query);

                // Liens des paramètres
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);

                // Exécuter la requête
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
