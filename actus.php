<?php
include_once "connexion.php";

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connect.php"); // Rediriger vers la page de connexion
    exit();
}

// Vérifier si l'utilisateur est un administrateur
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (!$isAdmin) {
    $message = "Vous n'avez pas les autorisations nécessaires pour ajouter une recette.";
} else {
    if (isset($_POST['send'])) {
        if (!empty($_FILES['image']) && isset($_POST['text']) && $_POST['text'] != "") {
            // Récupération de l'image
            $img_nom = $_FILES['image']['name'];
            $tmp_nom = $_FILES['image']['tmp_name'];

            if ($_FILES['image']['size'] > 1048576) {
                $message = "Veuillez choisir une image de taille inférieure à 1 Mo";
            } else {
                $time = time();
                $nouveau_nom_img = $time . "_" . basename($img_nom);

                $deplacer_img = move_uploaded_file($tmp_nom, "imgbdd/" . $nouveau_nom_img);

                if ($deplacer_img) {
                    $text = mysqli_real_escape_string($con, $_POST['text']);
                    $text1 = mysqli_real_escape_string($con, $_POST['text1']);
                    $text2 = mysqli_real_escape_string($con, $_POST['text2']);

                    $req = mysqli_query($con, "INSERT INTO images (image, nom_plat, description, temp_cuisson) VALUES ('$nouveau_nom_img', '$text', '$text1', '$text2')");

                    if ($req) {
                        header("Location: liste.php");
                        exit; 
                    } else {
                        $message = "Échec de l'ajout ! Erreur : " . mysqli_error($con);
                    }
                } else {
                    $message = "Erreur lors du déplacement de l'image.";
                }
            }
        } else {
            $message = "Veuillez remplir tous les champs !";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sty.css">
    <title>Recettes</title>
</head>
<body>
    <a href="liste.php" class="link">Liste des Recettes</a>
    <p class="error">
        <?php 
        if (isset($message)) echo $message;
        ?>
    </p>

    <?php if ($isAdmin):?>
        <form action="" method="POST" enctype="multipart/form-data">
            <label>Ajouter une photo</label>
            <input type="file" name="image" required>
            <label>Nom du plat</label>
            <textarea class="textarea" name="text" cols="30" rows="2" required></textarea>
            <label>Description</label>
            <textarea name="text1" cols="30" rows="2"></textarea>
            <label>Temps de cuisson</label>
            <textarea class="textarea" name="text2" cols="30" rows="2"></textarea>
            <input type="submit" value="Ajouter" name="send">
        </form>
    <?php endif; ?>
</body>
</html>