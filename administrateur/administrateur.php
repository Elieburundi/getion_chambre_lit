<?php     
include "Connexion.php"; 
include "Accueil.php"; 

if (isset($_POST["valider"])) {
    $recupUsername = $_POST["username"];
    $recupPswd = $_POST["pswd"];

    // Vérifier si l'utilisateur existe déjà
    $checkUser = $bdd->prepare("SELECT COUNT(*) FROM administrateur WHERE username = :username");
    $checkUser->bindParam(':username', $recupUsername);
    $checkUser->execute();
    
    if ($checkUser->fetchColumn() > 0) {
        echo "<script>alert('Le nom d\\'utilisateur existe déjà. Veuillez en choisir un autre.');</script>";
    } else {
        $insertAdmin = "INSERT INTO administrateur (username, password) VALUES ('$recupUsername', '$recupPswd')";
        $bdd->exec($insertAdmin); 
        header("location: affichageemploye.php");
        exit(); // Toujours utiliser exit après header
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 250px;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
            font-size: 28px;
        }

        #comment-form {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-control {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            #comment-form {
                padding: 15px;
                margin: 10px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <section id="comment-form">
        <h1>Ajout d'un utilisateur</h1>
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
                </label>
            </div>
            
            <button type="submit" name="valider">Envoyer</button>
        </form>
    </section>
</body>
</html>

