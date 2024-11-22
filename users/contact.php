<?php       
    include "Connexion.php";
    include "Accueil.php";
    
    if (isset($_POST["valider"])) {
        $recupNom = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
        $recupPrenom = htmlspecialchars($_POST["pname"], ENT_QUOTES, 'UTF-8');
        $recupAdd = htmlspecialchars($_POST["adress"], ENT_QUOTES, 'UTF-8');
        $recupTel = htmlspecialchars($_POST["tel"], ENT_QUOTES, 'UTF-8');
        $recupObj = htmlspecialchars($_POST["object"], ENT_QUOTES, 'UTF-8');
        $recupMsg = htmlspecialchars($_POST["msg"], ENT_QUOTES, 'UTF-8');
        
        // Vérification de l'existence du contact
        $trouvecontact = $bdd->prepare("SELECT * FROM contacted WHERE telephone = :telephone");
        $trouvecontact->bindParam(':telephone', $recupTel, PDO::PARAM_STR);
        $trouvecontact->execute();

        if ($trouvecontact->rowCount() > 0) {
            echo "<p style='color: red;'>Le contact existe déjà.</p>";
        } else {
            // Insertion du contact
            $insertCont = $bdd->prepare("INSERT INTO Contacted (nom, prenom, adresse, telephone, objet, message) 
                                          VALUES (:nom, :prenom, :adresse, :telephone, :objet, :message)");
            $insertCont->bindParam(':nom', $recupNom, PDO::PARAM_STR);
            $insertCont->bindParam(':prenom', $recupPrenom, PDO::PARAM_STR);
            $insertCont->bindParam(':adresse', $recupAdd, PDO::PARAM_STR);
            $insertCont->bindParam(':telephone', $recupTel, PDO::PARAM_STR);
            $insertCont->bindParam(':objet', $recupObj, PDO::PARAM_STR);
            $insertCont->bindParam(':message', $recupMsg, PDO::PARAM_STR);
            
            // Exécution de l'insertion
            $insertCont->execute();
            
            // Redirection après l'insertion
           header("Location: affichagecontacte.php"); // Remplacez par l'URL correcte
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 50px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-control {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #4CAF50;
        }

        textarea {
            resize: none;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        @media (max-width: 500px) {
            section {
                width: 90%;
            }
        }
    </style>
</head>
<body> 
    <section id="comment-form">
        <h1>Contactez-Nous</h1>
        <form action="" method="POST">
            <div class="form-control">
                <label for="name">Votre Nom:</label>
                <input type="text" name="name" id="name" required autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}">
            </div>
            <div class="form-control">
                <label for="pname">Votre Prénom:</label>
                <input type="text" name="pname" id="pname" required pattern="[A-Za-zÀ-ÿ\s]{2,20}">
            </div>
            <div class="form-control">
                <label for="adress">Votre Adresse:</label>
                <input type="text" name="adress" id="adress" required>
            </div>
            <div class="form-control">
                <label for="tel">Numéro de Téléphone:</label>
                <input type="tel" name="tel" id="tel" required pattern="[0-9]*">
            </div>
            <div class="form-control">
                <label for="object">Objet:</label>
                <input type="text" name="object" id="object" required>
            </div>
            <div class="form-control">
                <label for="msg">Votre Message:</label>
                <textarea name="msg" id="msg" cols="30" rows="5" required></textarea>
            </div>
            <button type="submit" name="valider">Envoyer</button>
        </form>
    </section>
</body>
</html>
