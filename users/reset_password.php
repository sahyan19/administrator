<?php 
include('../admin/config.php');

function generateRandomString($length = 5){
    $characters = '0123456789AZERTYUIOPQSDFGHJKLMWXCVBN';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++){
        $randomString += $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['send_link'])){
    $email = $_POST['email'];


    //vérifiaction de l'existance de l'email dans la base de données
    $query = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $query->execute([$email]);
    $row = $query->rowCount();

    if ($row == 1){
        $code = generateRandomString();


        //ici le lien est comme celui ci car j'ai utiliser virtualhost
        // ainsi j'ai utiiser sur mon ordinateur comme adresse du site : www.admin.mg
        $link = 'href="http://www.admin.mg/check_email.php?email='.$email.'&code='.$code.'"';
        
        $link2 = '<span style="width:100%"><a style="padding: 100px; border-radius:30px; background:#a8edbc" '.$link.'> Lien </a></span>';

        echo $link2;

    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <h2>Réinitialisation mot de passe </h2>
        <div id="login-form">
            <form action="check_email.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="submit" name="send_link" value="Envoyer">
            </form>
        </div>
    </div>
</body>
</html>
