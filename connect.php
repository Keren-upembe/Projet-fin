<?php
include_once "connexion.php";

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['connexion'])) {

    if (!empty($_POST['email']) && !empty($_POST['pass'])) {

        $email = mysqli_real_escape_string($con, $_POST['email']);
        $pass = mysqli_real_escape_string($con, $_POST['pass']);

        $test_connexion = mysqli_query($con, "SELECT * FROM utilisateurs WHERE email = '$email'");

        if ($test_connexion && mysqli_num_rows($test_connexion) > 0) {

            $user = mysqli_fetch_assoc($test_connexion);

            if (password_verify($pass, $user['pass'])) {

                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                header("Location:index.php");

                exit();

            } else {
                $message = "<p class='error'>Mot de passe incorrect.</p>";
            }
        } else {
            $message = "<p class='error'>Aucun compte trouvé avec cet email.</p>";
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
    <title>Connexion</title>
</head>
<body class="body">
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
    <div class="container">
        <form action="" method="POST">
            <h2>CONNEXION</h2>

            <div class="error">
                <?php 
                if (!empty($message)) echo $message;
                ?>
            </div>

            <label>Email</label>
            <input type="email" name="email" placeholder="Email">

            <label>Mot de passe</label>
            <input type="password" name="pass" placeholder="Mot de passe">

            <button type="submit" name="connexion">Se connecter</button>
            <a class="button" href="inscription.php">S'inscrire</a>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>