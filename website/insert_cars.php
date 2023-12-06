<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = connectDB();

        if ($conn) {
            $type = isset($_POST['type']) ? $_POST['type'] : '';
            $couleur = isset($_POST['couleur']) ? $_POST['couleur'] : '';
            $ndp = isset($_POST['ndp']) ? $_POST['ndp'] : '';
            $etat = isset($_POST['etat']) ? $_POST['etat'] : '';
            $conducteur = isset($_POST['conducteur']) ? $_POST['conducteur'] : '';

            if (!empty($type) && !empty($couleur) && !empty($ndp) && !empty($etat) && !empty($conducteur)) {
                $query = "INSERT INTO voiture (type, couleur, nombre_de_places, etat, conducteur) VALUES (:type, :couleur, :ndp, :etat, :conducteur);";
                $stmt = $conn->prepare($query);

                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':couleur', $couleur);
                $stmt->bindParam(':ndp', $ndp);
                $stmt->bindParam(':etat', $etat);
                $stmt->bindParam(':conducteur', $conducteur);

                if ($stmt->execute()) {
                    header("Location: cars.php");
                } else {
                    echo "Erreur lors de l'insertion du vehicule.";
                }
            } 
            else {
                echo "Veuillez fournir un type, une couleur, un nombre de places, un etat et un conducteur.";
            }
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
?>
