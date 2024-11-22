<?php
include "connexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="login2.css">-->
    <title>connection</title>
</head>
<body>
<div class="login-form">
    <h2>Connexion</h2>
    <?php if (isset($error)):?>
    <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit" name="connecter">Se connecter</button>
        </div>
    </form>
</div>
<?php
if(isset($_POST["connecter"])){
    
    echo "egoooo";
    $recupuser = $_POST["username"];
    $recuppassword = $_POST["password"];
    $trouveusers = $bdd->prepare("Select * from administrator where username= :user and password= :pass");
                $trouveusers->bindParam(':user', $recupuser, PDO::PARAM_STR);
                $trouveusers->bindParam(':pass', $recuppassword, PDO::PARAM_STR);
                $trouveusers->execute();
                if($trouveusers->rowCount() > 0){
                    header("location:index.php");
                    echo "egoooo";
                }
                else{
                    echo "Parametre incorrect";
                }
    }
?>
</body>
</html>