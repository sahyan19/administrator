<?php
session_start();
include('../admin/config.php');

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Dashboard</title>
</head>
<body>
<div class="container">
    <h2>Liste des utilisateurs</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Code PHP pour afficher les utilisateurs de la base de données
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>{$user['id']}</td>";
                    echo "<td>{$user['first_name']}</td>";
                    echo "<td>{$user['last_name']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td>
                            <a href='view.php?id={$user['id']}' class='action-btn'>Voir plus</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<button><a href="../admin/logout.php">Se Déconnecter</a></button>
</body>
</html>