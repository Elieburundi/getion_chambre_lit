<html>
<head>
<?php
include "connexion.php";
include 'Accueil.php';

if(isset($_POST["envoyer"])) {
    $recupnom = $_POST["nom_bloc"];
    $recupdescr = $_POST["description"];

    // Vérification des doublons
    $verifDoublon = $bdd->prepare("SELECT * FROM bloc WHERE nom_bloc = :nom_bloc");
    $verifDoublon->bindParam(':nom_bloc', $recupnom);
    $verifDoublon->execute();

    if ($verifDoublon->rowCount() > 0) {
        echo "<p style='color: red; text-align: center;'>Ce bloc existe déjà.</p>";
    } else {
        // Insertion du bloc s'il n'existe pas déjà
        $Insertionbloc = $bdd->prepare("INSERT INTO bloc (nom_bloc, description) VALUES (:nom_bloc, :description)");
        $Insertionbloc->bindParam(':nom_bloc', $recupnom);
        $Insertionbloc->bindParam(':description', $recupdescr);

        if ($Insertionbloc->execute()) {
            header("Location: affichagebloc.php"); // Redirection après ajout
            exit; // Assurez-vous de quitter après redirection
        } else {
            echo "<p style='color: red; text-align: center;'>Erreur lors de l'ajout du bloc.</p>";
        }
    }
}
?>

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: blue;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #4B0082;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: aqua;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 10px;
        }

        td {
            padding: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        input[type="submit"], input[type="reset"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }

        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<meta charset="utf_8"/>
<form method="POST" action="">
<table>
<tr>
<th>Nom du bloc</th>
<th><input type="text" name="nom_bloc" required></th>
</tr>
<tr>
<th>Description</th>
<th><input type="text" name="description" required></th>
</tr>
<tr> 
<th></th>
<td> 
    <input type="submit" name="envoyer" value="Enregistrer"/>
    <!--  <input type="reset" value="Supprimer"/> -->
</td>
</tr>
</table>
</form>

</body>
</html>
