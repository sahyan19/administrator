<?php
include('../admin/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Vérifier le token et l'expiration
    $stmt = $conn->prepare('SELECT id FROM users WHERE reset_token = :token AND reset_token_expires > NOW()');
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Mettre à jour le mot de passe et réinitialiser le token
        $stmt = $conn->prepare('UPDATE users SET password = :password, reset_token = NULL, reset_token_expires = NULL WHERE id = :id');
        $stmt->execute([
            'password' => $new_password,
            'id' => $user['id']
        ]);

        echo 'Votre mot de passe a été réinitialiser avec succès';
    } else {
        echo 'Token Invalide ou expirer';
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die('Pas de token');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Réinitialisation mot de passe</title>
</head>
<body>
<div class="container">
    <form method="POST" action="reset_password_form.php">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <input type="password" name="password" placeholder="Enter new password" required>
        <button type="submit">Réinitialiser</button>
    </form><br><br>
    <button><a href="../index.php">Connexion</a></button>
</div>
</body>
</html>