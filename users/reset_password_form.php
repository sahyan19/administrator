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

        echo 'Your password has been reset successfully.';
    } else {
        echo 'Invalid or expired token.';
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    die('No token provided.');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Connexion/Inscription</title>
</head>
<body>
<form method="POST" action="reset_password_form.php">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <input type="password" name="password" placeholder="Enter new password" required>
    <button type="submit">Reset Password</button>
</form>
</body>
</html>
