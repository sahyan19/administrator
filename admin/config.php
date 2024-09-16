<?php
      
    $host = 'localhost';
    $db = 'inscription';
    $user = 'sahyan'; 
    $pass = 'azertyuiop';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        
        // Définir le mode d'erreur PDO à Exception pour capturer les erreurs
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        die("Connexion échouée: " . $e->getMessage());
    }
?>
