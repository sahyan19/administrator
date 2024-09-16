<?php 
include('../admin/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    $stmt = $conn->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Générer un token sécurisé
        $token = bin2hex(random_bytes(50));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Mettre à jour la base de données avec le token et l'expiration
        $stmt = $conn->prepare('UPDATE users SET reset_token = :token, reset_token_expires = :expires WHERE email = :email');
        $stmt->execute([
            'token' => $token,
            'expires' => $expires,
            'email' => $email
        ]);

        // Envoyer l'email de réinitialisation
        $reset_link = 'http://localhost/reset_password_form.php?token=' . $token;
        $subject = 'Password Reset';
        $message = "Click the following link to reset your password: $reset_link";
        $headers = 'From: no-reply@yourdomain.com' . "\r\n" .
                   'Reply-To: no-reply@yourdomain.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        mail($email, $subject, $message, $headers);

        echo "un lien de réinitialisation est envoyer à votre email";
    } else {
        echo "Pas de compte trouver avec cette email.";
    }
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
<form method="POST" action="reset_password.php">
    <input type="email" name="email" placeholder="Entrer votre email" required>
    <button type="submit">Envoyer</button>
</form>
</body>
</html>