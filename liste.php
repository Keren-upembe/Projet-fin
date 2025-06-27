<?php
    session_start();

    
    if (!isset($_SESSION['user_id'])) {
    header("Location: connect.php");
    exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sty.css">
    <title>Liste des recettes</title>
</head>
<body>
    <section>

        <?php 
        include_once "connexion.php";

        $req = mysqli_query($con, "SELECT * FROM images");

        if (mysqli_num_rows($req) < 1) {
            ?> 
            <p class="vide_message">La liste des photos est vide</p>
            <?php
        } else {
            while ($row = mysqli_fetch_assoc($req)) {
                ?>  
                <div class="box">
                    <img class="img_principale" src="imgbdd/<?php echo htmlspecialchars($row['image']); ?>" alt="Image de la recette">
                    <div class="regroupe">
                        <div><span>Nom du plat :</span> <?php echo htmlspecialchars($row['nom_plat']); ?></div>
                        <div class="description"><span>Description : </span> <?php echo htmlspecialchars($row['description']); ?></div>
                        <div><span>Temps de cuisson :</span> <?php echo htmlspecialchars($row['temp_cuisson']); ?></div>
                        <a class="delete" href="supprime.php?id=<?php echo $row['id']; ?>">
                            <img class="delete-icon" src="source/delete.png">
                        </a>
                    </div>
                </div>
                <?php
            }
        }
        ?>

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
        <a class="link" href="actus.php">Ajouter une Recette</a>
        
    </section>

    <script src="script.js"></script>
</body>
</html>