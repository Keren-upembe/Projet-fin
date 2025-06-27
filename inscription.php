<?php 

    include_once"connexion.php";
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inscription'])) {

        if (!empty($_POST['email']) && !empty($_POST['pass'])) {

            $email = mysqli_real_escape_string($con, $_POST['email']);
            $pass = mysqli_real_escape_string($con, $_POST['pass']);

            $test_email = mysqli_query($con, "SELECT * FROM utilisateurs WHERE email = '$email'");
        
            if ($test_email && mysqli_num_rows($test_email) > 0) {
                $message = "<p class='error'>Cet email est déjà utilisé. Veuillez en choisir un autre.</p>";
            } else {
                $mask_pass = password_hash($pass, PASSWORD_DEFAULT);
                $req = mysqli_query($con, "INSERT INTO utilisateurs (email, pass) VALUES ('$email', '$mask_pass')");
            
                if ($req) {
                    $message = "<p class='success'>Inscription réussie! Vous pouvez vous connecter.</p>";
                } else {
                    $message = "<p class='error'>Erreur lors de l'inscription. Veuillez réessayer.</p>";
                }
            }
        } else {
            $message = "<p class='error'>Veuillez remplir tous les champs !</p>";
        }
    }



?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>INSCRIPTION</title>
</head>
<body>

    <div class="menu-img">
        <img src="source/menu.png" alt="menu" id="menu">
    </div>
    <div class="show">
        <nav class="left-nav">
            <a href="index.php">ACCUEIL</a>
            <a href="apropos.php">À PROPOS</a>
            <a href="footer.php">CONTACT</a>
            <a href="liste.php">RECETTES</a>
            <a href="connect.php">CONNEXION</a>
            <a href="deconnexion.php">DÉCONNEXION</a>
        </nav>
    </div>

    <form method="POST">
        <h2>INSCRIPTION</h2>

        <div class="error">
            <?php 
                if (!empty($message)) echo $message;
            ?>
        </div>
        <label>Email</label>
        <input type="email" name="email" placeholder="Email">

        <label>Mot de passe</label>
        <input type="password" name="pass" placeholder="Mot de passe">

            <button type="submit" name="inscription">S'inscrire</button>
            <a class="button" href="connect.php">Se connecter</a>
            
        </form>

        <script src="script.js"></script>

        <!--ajout adm :UPDATE utilisateurs SET role = 'admin' WHERE email = 'admin@example.com';-->
    
</body>
</html>