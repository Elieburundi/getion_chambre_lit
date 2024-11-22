<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ad</title>
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50vh;
        margin: 180px;
        background-color: cyan;
        font-family: Arial, sans-serif;
    }

    table {
        width: 50%;
        border-collapse: collapse;
        margin-top: 20px;
        text-align: left;
        background-color: white;
    }

    th, td {
        padding: 12px;
        border: 1px solid black;
        text-align: center;
    }

    th {
        background-color: darkcyan;
        color: white;
    }

    td a {
        text-decoration: none;
        color: blue;
        font-weight: bold;
    }

    td a:hover {
        color: red;
    }

    form {
        margin-top: 100px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: lightgray;
    }
    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        table {
            width: 50%;
        }

        body {
            margin: 150px;
            height: auto;
        }
    }
</style>
    <?php include "Connexion.php" ?>
    <?php include "Accueil.php" ?>
</head>
<body>
    <br><br>
    <section id="comment-form">
        <h1> Ajout d'un utilisateur </h1>
        <form action="" method="POST">
            <div class="form-control">
                <label for="username">
                    Username
                    <input type="text" name="username" id="username" required pattern="^[a-zA-Z0-9_]{3,20}$">
                </label>
            </div>

            <div class="form-control">
                <label for="pswd">
                    Mot de passe
                    <input type="password" name="pswd" id="pswd" required>
                </label><br><br>
            </div>
            <button type="submit" name="valider">Envoyer</button>
            
        </form>
 
        <?php
            if(isset($_POST["valider"])){
                $recupUsername = $_POST["username"];
                $recupPswd = $_POST["pswd"];
    
                $insertAdmin = "insert into administrateur(username,password) values('$recupUsername','$recupPswd')";

                $bdd->exec($insertAdmin); 
                header("location: affichageadmin.php");

            }
        ?>
    </section>
</body>
</html>