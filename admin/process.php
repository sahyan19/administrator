<?php
session_start();
include('config.php');

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$parcours = $_POST['parcours'];
$sexe = $_POST['sexe'];
$date_naissance = $_POST['date_naissance'];
$adresse = $_POST['adresse'];

try {
    $sql = "INSERT INTO etudiant (nom, prenom, parcours, sexe, date_naissance, adresse)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$nom, $prenom, $parcours, $sexe, $date_naissance, $adresse])) {
        echo "<h2>Données enregistrées avec succès.</h2>";
    } else {
        echo "Erreur lors de l'enregistrement des données.";
    }
    
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <button><a href="display.php">Afficher les étudiants</a><br></button>
    <button><a href="logout.php">Se déconnecter</a></button>
</body>
</html>