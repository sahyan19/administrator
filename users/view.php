<?php
include('../admin/config.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations de l'utilisateur
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error'] = "Utilisateur non trouvé!";
        header("Location: dashboard.php");
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Voir l'utilisateur</title>
</head>
<body>
    <div class="container">
        <h2>Informations de l'utilisateur</h2>
        <p><strong>Prénom :</strong> <?= $user['first_name'] ?></p>
        <p><strong>Nom :</strong> <?= $user['last_name'] ?></p>
        <p><strong>Email :</strong> <?= $user['email'] ?></p>
        <a href="dashboard.php">Retour au tableau de bord</a>
    </div>
</body>
</html>
