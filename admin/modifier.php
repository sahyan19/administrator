<?php
session_start();
include('config.php');

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $parcours = $_POST['parcours'];
    $sexe = $_POST['sexe'];
    $date_naissance = $_POST['date_naissance'];
    $adresse = $_POST['adresse'];

    try {
        $sql = "UPDATE etudiant SET nom=?, prenom=?, parcours=?, sexe=?, date_naissance=?, adresse=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt->execute([$nom, $prenom, $parcours, $sexe, $date_naissance, $adresse, $id])) {
            echo "Données modifiées avec succès.";
        } else {
            echo "Erreur lors de la mise à jour.";
        }

        header("Location: display.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

try {
    $sql = "SELECT * FROM etudiant WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        echo "Aucun étudiant trouvé.";
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<link rel='stylesheet' href='styles.css'>
<h2>Modifier l'étudiant</h2>
<form action="" method="POST">
    Nom: <input type="text" name="nom" value="<?= $etudiant['nom']; ?>" required><br><br>
    Prénom: <input type="text" name="prenom" value="<?= $etudiant['prenom']; ?>" required><br><br>
    Parcours: <input type="text" name="parcours" value="<?= $etudiant['parcours']; ?>" required><br><br>
    Sexe:
    <input type="radio" name="sexe" value="Homme" <?= $etudiant['sexe'] == 'Homme' ? 'checked' : ''; ?>> Homme
    <input type="radio" name="sexe" value="Femme" <?= $etudiant['sexe'] == 'Femme' ? 'checked' : ''; ?>> Femme<br><br>
    Date de naissance: <input type="date" name="date_naissance" value="<?= $etudiant['date_naissance']; ?>" required><br><br>
    Adresse: <textarea name="adresse" required><?= $etudiant['adresse']; ?></textarea><br><br>
    <button type="submit">Modifier</button><br>
</form>

<button><a href="display.php">Annuler</a></button>

