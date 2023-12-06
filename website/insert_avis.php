<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            // Récupérer les valeurs du formulaire
            $id_trajet = isset($_POST['id_trajet']) ? $_POST['id_trajet'] : '';
            $auteur = isset($_POST['auteur']) ? $_POST['auteur'] : '';
            $destinataire = isset($_POST['destinataire']) ? $_POST['destinataire'] : '';
            $note = isset($_POST['note']) ? $_POST['note'] : '';
            $commentaire = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';

            // Vérifier si les valeurs sont non vides
            if (!empty($id_trajet) && !empty($auteur) && !empty($destinataire) && !empty($note)) {
                // Préparer la requête d'insertion
                $query = "INSERT INTO avis (id_trajet, auteur, destinataire, note, commentaire) VALUES (:id_trajet, :auteur, :destinataire, :note, :commentaire);";
                $stmt = $conn->prepare($query);

                // Liens des paramètres
                $stmt->bindParam(':id_trajet', $id_trajet);
                $stmt->bindParam(':auteur', $auteur);
                $stmt->bindParam(':destinataire', $destinataire);
                $stmt->bindParam(':note', $note);
                $stmt->bindParam(':commentaire', $commentaire);

                // Exécuter la requête
                if ($stmt->execute()) {
                    header("Location: avis.php");
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
