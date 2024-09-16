<?php
session_start();
include('config.php');

try {
    $sql = "SELECT * FROM etudiant";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<link rel='stylesheet' href='styles.css'>";

    // Vérification s'il y a des résultats
    if ($stmt->rowCount() > 0) {
        echo "<table border='1'>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Parcours</th>
                    <th>Sexe</th>
                    <th>Date de Naissance</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>";

        // Boucle pour afficher les résultats
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['nom']) . "</td>
                    <td>" . htmlspecialchars($row['prenom']) . "</td>
                    <td>" . htmlspecialchars($row['parcours']) . "</td>
                    <td>" . htmlspecialchars($row['sexe']) . "</td>
                    <td>" . htmlspecialchars($row['date_naissance']) . "</td>
                    <td>" . htmlspecialchars($row['adresse']) . "</td>
                    <td>
                        <button class='modifier'><a href='modifier.php?id=" . $row['id'] . "'>Modifier</a></button>
                        <button class='detail'><a href='voir.php?id=" . $row['id'] . "'>Voir Plus</a></button>
                        <button class='supprimer'><a href='supprimer.php?id=" . $row['id'] . "' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet étudiant ?\");'>Supprimer</a></button>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun étudiant enregistré.";
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
    <button><a href="insertion.php">Sauvegarder des données</a></button>
    <button><a href='../index.php'>Retour à l'accueil</a></button>
</body>
</html>
