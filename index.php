<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Connexion/Inscription</title>
</head>
<body>
    <div class="container">
        <h2>Bienvenue</h2>
        <div class="nav">
            <a href="#" id="login-btn">Connexion</a>
            <a href="#" id="signup-btn">Inscription</a>
        </div>

        <!-- Formulaire de connexion -->
        <div id="login-form">
            <h3>Connexion</h3>
            <form action="/users/login.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required><br>
                <button type="submit">Se connecter</button>
            </form><br><br>
        </div>

        <!-- Formulaire d'inscription (masqué par défaut) -->
        <div id="signup-form" style="display: none;">
            <h3>Inscription</h3>
            <form action="/users/register.php" method="POST">
                <input type="text" name="first_name" placeholder="Prénom" required>
                <input type="text" name="last_name" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required><br>
                <button type="submit">S'inscrire</button>
            </form><br><br>
        </div>
        <button><a href="/admin/index.php">Se Connecter en Admin</a></button><br><br>
        <a href="/users/check_email.php">mot de passe oublié ?</a>
    </div>

    <script>
        // Gérer le changement entre Connexion et Inscription
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');
        const loginBtn = document.getElementById('login-btn');
        const signupBtn = document.getElementById('signup-btn');

        loginBtn.addEventListener('click', function() {
            loginForm.style.display = 'block';
            signupForm.style.display = 'none';
        });

        signupBtn.addEventListener('click', function() {
            loginForm.style.display = 'none';
            signupForm.style.display = 'block';
        });
    </script>
</body>
</html>
