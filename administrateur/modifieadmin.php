<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Administrateur</title>
    <?php 
        include "Connexion.php";
        $modifieadmin = $bdd->query("Select * from administrateur where id_admin=".$_GET['mod']);
        $dataRecup = $modifieadmin->fetch();   

    ?>
    <?php include "Accueil.php" ?>
</head>
<body>
    <br><br>
    <section id="comment-form">
        <h1> Modification d'un utilisateur </h1>
        <form action="" method="POST">
            <div class="form-control">
                <label for="username">
                    Username
                    <input type="text" value="<?php echo $dataRecup["username"]; ?>" name="name" id="username" required pattern="^[a-zA-Z0-9_]{3,20}$">
                </label>
            </div>

            <div class="form-control">
                <label for="pswd">
                    Mot de passe
                    <input type="password" value="<?php echo $dataRecup["password"]; ?>" name="pswd" id="pswd" required>
                </label><br><br>
            </div>
            <button type="submit" name="valider">Modifier</button>
            
        </form>
 
        <?php
            if(isset($_POST["valider"])){
                $recupUsername = $_POST["name"];
                $recupPswd = $_POST["pswd"];
    
                $modifAdmin = "update administrateur set username='$recupUsername',password='$recupPswd' where id_admin=".$_GET['mod'];

                $bdd->exec($modifAdmin); 
                header("location: affichageadmin.php");

            }
        ?>
    </section>
</body>
</html>