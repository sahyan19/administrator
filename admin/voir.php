<?php
session_start();
include('config.php');

$id = $_GET['id'];

try {
    $sql = "SELECT * FROM etudiant WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    $stmt->execute([$id]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;

?>

<link rel="stylesheet" href="styles.css">
<h2>Détails de l'étudiant</h2>
<p><strong>Nom :</strong> <?= $etudiant['nom']; ?></p>
<p><strong>Prénom :</strong> <?= $etudiant['prenom']; ?></p>
<p><strong>Parcours :</strong> <?= $etudiant['parcours']; ?></p>
<p><strong>Sexe :</strong> <?= $etudiant['sexe']; ?></p>
<p><strong>Date de naissance :</strong> <?= $etudiant['date_naissance']; ?></p>
<p><strong>Adresse :</strong> <?= $etudiant['adresse']; ?></p>

<button><a href="display.php">Retour à la liste</a></button>
<button><a href="logout.php">Se déconnecter</a></button>
