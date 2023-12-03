<?php
function connectDB()
{
    $host = 'postgres-container';
    $dbname = 'covoiturage';
    $user = 'postgres';
    $password = 'postgres';

    try {
        $conn = new PDO("pgsql:host=$host;dbname=$dbname;user=$user;password=$password");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        return null;
    }
}
