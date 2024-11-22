<?php
include "connexion.php"; 
include "Accueil.php";

if (isset($_GET['mod'])) {
    // Récupérer les informations du lit
    $id_lit = $_GET['mod'];
    $affichagelit = $bdd->prepare("SELECT * FROM lit as li 
        JOIN bloc as bl ON li.id_bloc = bl.id_bloc 
        JOIN chambre as chamb ON chamb.id_chambre = li.id_chambre 
        WHERE id_lit = :id_lit");
    $affichagelit->bindParam(':id_lit', $id_lit, PDO::PARAM_INT);
    $affichagelit->execute();
    $datarecup_lit = $affichagelit->fetch();
} else {
    echo "Aucun lit sélectionné.";
    exit;
}

// Mise à jour des informations
if (isset($_POST["envoyer"])) {
    $recupenum = $_POST["numero_lit"];
    $recupstatut = $_POST["statut"];
    $recupbloc = $_POST["bloc"];
    $recupchambre = $_POST["chambre"];
    $image_lit = $datarecup_lit["image_lit"]; // Conserver l'ancienne image par défaut

    // Vérifier si une nouvelle image a été téléchargée
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $image_type = $_FILES["image"]["type"];

        if (in_array($image_type, $allowed_types)) {
            // Déplacer l'image téléchargée
            $image_lit = $_FILES["image"]["name"];
            $destination = "Image/" . $image_lit;

            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
                echo "Erreur lors du téléchargement de l'image.";
                exit;
            }
        } else {
            echo "Type de fichier inacceptable, veuillez utiliser (jpeg, png, ou gif).";
            exit;
        }
    }

    // Préparer la mise à jour
    $insertlit = $bdd->prepare("UPDATE lit SET numero_lit = :numero_lit, statut = :statut, id_bloc = :id_bloc, id_chambre = :id_chambre, image_lit = :image_lit WHERE id_lit = :id_lit");
    $insertlit->bindParam(':numero_lit', $recupenum, PDO::PARAM_STR);
    $insertlit->bindParam(':statut', $recupstatut, PDO::PARAM_STR);
    $insertlit->bindParam(':id_bloc', $recupbloc, PDO::PARAM_INT);
    $insertlit->bindParam(':id_chambre', $recupchambre, PDO::PARAM_INT);
    $insertlit->bindParam(':image_lit', $image_lit, PDO::PARAM_STR);
    $insertlit->bindParam(':id_lit', $id_lit, PDO::PARAM_INT);

    // Exécuter la mise à jour
    if ($insertlit->execute()) {
        // Redirection vers la page d'affichage
        header("Location: affichagelit.php");
        exit(); // Toujours utiliser exit après header
    } else {
        echo "Erreur lors de la mise à jour du lit.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Lit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 50px;
            padding: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST" action="" enctype="multipart/form-data">
        <table>
            <tr>
                <th>ID Lit</th>
                <th><input type="text" value="<?php echo $datarecup_lit["id_lit"]; ?>" name="id_lit" required readonly></th>
            </tr>
            <tr>
                <th>Numéro Lit</th>
                <th><input type="text" value="<?php echo $datarecup_lit["numero_lit"]; ?>" name="numero_lit" required></th>
            </tr>
            <tr>
                <th>Statut</th>
                <th><input type="text" value="<?php echo $datarecup_lit["statut"]; ?>" name="statut" required></th>
            </tr>
            <tr>
                <th>Bloc</th>
                <th>
                    <select name="bloc" required>
                        <option value="" disabled>Sélectionnez un bloc</option>
                        <?php
                        // Récupérer tous les blocs
                        $affichagebloc = $bdd->query("SELECT * FROM bloc");
                        while ($datarecup_bloc = $affichagebloc->fetch()) {
                            $selected = $datarecup_lit["id_bloc"] == $datarecup_bloc["id_bloc"] ? "selected" : "";
                        ?> 
                            <option value="<?php echo $datarecup_bloc["id_bloc"]; ?>" <?php echo $selected; ?>>
                                <?php echo $datarecup_bloc["nom_bloc"]; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </th>
            </tr>
            <tr>
                <th>Chambre</th>
                <th>
                    <select name="chambre" required>
                        <option value="" disabled>Sélectionnez une chambre</option>
                        <?php
                        // Récupérer toutes les chambres
                        $affichagechambre = $bdd->query("SELECT * FROM chambre");
                        while ($datarecup_chambre = $affichagechambre->fetch()) {
                            $selected = $datarecup_lit["id_chambre"] == $datarecup_chambre["id_chambre"] ? "selected" : "";
                        ?> 
                            <option value="<?php echo $datarecup_chambre["id_chambre"]; ?>" <?php echo $selected; ?>>
                                <?php echo $datarecup_chambre["numero"]; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </th>
            </tr>
            <tr>
                <th>Image</th>
                <th>
                    <input type="file" name="image">
                    <p>Actuelle : <img src="Image/<?php echo $datarecup_lit['image_lit']; ?>" alt="Image du lit" style="max-width: 100px; max-height: 100px;"></p>
                </th>
            </tr>
            <tr>
                <td><input type="submit" value="Envoyer" name="envoyer"></td>
            </tr>
        </table>
    </form>
</body>
</html>
