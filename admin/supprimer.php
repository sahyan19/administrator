<?php
session_start();
include('config.php');

$id = $_GET['id'];

try {
    $sql = "DELETE FROM etudiant WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$id])) {
        echo "Étudiant supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'étudiant.";
    }
    
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$conn = null;

header("Location: display.php");
exit();

?>
