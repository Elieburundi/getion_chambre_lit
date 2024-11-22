<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #007bff;
            font-size: 36px;
        }

        #comment-form {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
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

        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        @media (max-width: 600px) {
            #comment-form {
                padding: 20px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body> 
    <header id="main-navigation">
        <h1>Bienvenue</h1>
    </header>
    <section id="comment-form">
        <h1>Connectez Vous</h1>
        <form action="" method="POST">
            <div class="form-control">
                <label for="username">
                    Nom Utilisateur: 
                    <input type="text" name="username" id="username" required autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}">
                </label>
            </div>
            <div class="form-control">
                <label for="password">
                    Mot de passe: 
                    <input type="password" name="password" id="password" required>
                </label>
            </div>
            <button type="submit" name="valider">Login</button>
        </form>
        <?php
        include "connexion.php"; 
        if (isset($_POST["valider"])) {
            $recupuser = $_POST["username"];
            $recuppassword = $_POST["password"];
            $trouveusers = $bdd->prepare("SELECT * FROM administrateur WHERE username = :user AND password = :pass");
            $trouveusers->bindParam(':user', $recupuser, PDO::PARAM_STR);
            $trouveusers->bindParam(':pass', $recuppassword, PDO::PARAM_STR);
            $trouveusers->execute();
            if ($trouveusers->rowCount() > 0) {
                header("location: Accueil.php");
                exit(); // Assurez-vous d'utiliser exit après header
            } else {
                echo '<div class="error-message">Paramètre incorrect</div>';
            }
        }
        ?>
    </section>
    <footer class="footer">
        <p style="text-align: center;">© 2024 Votre entreprise</p>
    </footer>
</body>
</html>

