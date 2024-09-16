<?php 
	session_start();
	include ('config.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Inscription Étudiant</title>
</head>
<body>
    <h2>Formulaire d'inscription des étudiants</h2>
    <form action="process.php" method="POST">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br><br>

        <label for="parcours">Parcours :</label>
        <select id="parcours" name="parcours" required>
            
            <?php
            try {
                $sql = "SELECT id, nom_parcours FROM parcours";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                // Récupérer les résultats
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $row['nom_parcours'] . "'>" . $row['nom_parcours'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Aucun parcours disponible</option>";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }

            ?>
            
        </select><br><br>

        <label>Sexe :</label>
        <input type="radio" id="homme" name="sexe" value="Homme" required>
        <label for="homme">Homme</label>
        <input type="radio" id="femme" name="sexe" value="Femme" required>
        <label for="femme">Femme</label><br><br>

        <label for="date_naissance">Date de naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" required><br><br>

        <label for="adresse">Adresse :</label>
        <textarea id="adresse" name="adresse" required></textarea><br><br>

        <button type="submit">Soumettre</button><br><br>
    </form>
    
    <?php 
        echo "<button><a href='display.php'>Voir le tableau de données</a></button>"
    ?>

</body>
</html>
