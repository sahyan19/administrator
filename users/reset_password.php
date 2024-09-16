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

        // Générer le lien de réinitialisation avec le token
        $reset_link = 'http://localhost:8000/users/reset_password_form.php?token=' . urlencode($token);

        // Envoyer l'email de réinitialisation
        $subject = 'Réinitialisation de mot de passe';
        $message = "Cliquer ici pour réinitialiser votre mot de passe: $reset_link";
        $headers = 'From: admin@gmail.com' . "\r\n" .
                   'Reply-To: reset@gmail.com' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        mail($email, $subject, $message, $headers);

        echo '<h2>Un lien de réinitialisation est envoyer à votre mail</h2>';
    } else {
        echo '<h2>Pas de compte trouver avec cette email</h2>';
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
<div class="container">
    <form method="POST" action="reset_password.php">
        <input type="email" name="email" placeholder="Entrer votre email" required>
        <button type="submit">Envoyer</button>
    </form>
</div>
</body>
</html>