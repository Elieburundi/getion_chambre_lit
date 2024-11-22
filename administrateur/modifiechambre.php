<?php
include "connexion.php"; 
include "Accueil.php";

$affichagechambre = $bdd->query("SELECT * FROM chambre AS ch JOIN bloc AS bl ON ch.id_bloc = bl.id_bloc WHERE id_chambre='" . $_GET['mod'] . "'");
$datarecup = $affichagechambre->fetch();

if (isset($_POST["envoyer"])) {
    $recupenum = $_POST["numero"];
    $recuptype = $_POST["type"];
    $recupstatut = $_POST["statut"];
    $recupbloc = $_POST["bloc"];
    $image_chambre = $datarecup["image_chambre"]; // Conserver l'ancienne image par défaut

    // Vérification de l'upload de l'image
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $image_type = $_FILES["image"]["type"];

        if (in_array($image_type, $allowed_types)) {
            $image_chambre = $_FILES["image"]["name"];
            $destination = "Image/" . basename($image_chambre);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
                // Image téléchargée avec succès
            } else {
                echo "Erreur lors du téléchargement de l'image.";
                exit;
            }
        } else {
            echo "Type de fichier inacceptable, veuillez utiliser (jpeg, png, ou gif).";
            exit;
        }
    }

    // Préparation de la mise à jour
    $insertchambre = "UPDATE chambre SET numero='$recupenum', type='$recuptype', statut='$recupstatut', id_bloc='$recupbloc', image_chambre='$image_chambre' WHERE id_chambre='" . $_GET['mod'] . "'";
    $bdd->exec($insertchambre);
    header("Location: affichagechambre.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier Chambre</title>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200vh;
        margin: 500;
        background-color: #e0f7fa;
        font-family: Arial, sans-serif;
    }
    form {
        background-color: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 400px;
    }
    table {
        width: 100%;
        border-spacing: 15px;
    }
    th {
        text-align: left;
        color: #00796b;
        font-size: 16px;
        font-weight: bold;
        padding-bottom: 10px;
    }
    input[type="text"], select {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 14px;
    }
    input[type="file"] {
        width: 100%;
    }
    input[type="submit"] {
        background-color: #00796b;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
        background-color: #004d40;
    }
    @media (max-width: 768px) {
        form {
            width: 90%;
        }
    }
</style>
</head>
<body>
<form method="POST" action="" enctype="multipart/form-data">
<table>
<tr>
<th>Numéro</th>
<th><input type="text" value="<?php echo $datarecup["numero"] ?>" name="numero" required></th>
</tr>
<tr>
<th>Type</th>
<th><input type="text" value="<?php echo $datarecup["type"] ?>" name="type" required></th>
</tr>
<tr>
<th>Statut</th>
<th><input type="text" value="<?php echo $datarecup["statut"] ?>" name="statut" required></th>
</tr>
<tr>
<th>Bloc</th>
<th>
    <select name="bloc" required>
        <option value="" disabled selected>Sélectionnez un bloc</option>
        <?php
        $affichagebloc = $bdd->query("SELECT * FROM bloc");
        while ($datarecup_bloc = $affichagebloc->fetch()) {
            echo '<option value="' . $datarecup_bloc["id_bloc"] . '">' . $datarecup_bloc["nom_bloc"] . '</option>';
        }
        ?>
    </select>
</th>
</tr>
<tr>
<th>Image</th>
<th>
    <input type="file" name="image" accept="image/*">
    <p>Actuelle : <img src="Image/<?php echo htmlspecialchars($datarecup['image_chambre']); ?>" alt="Image de la chambre" style="max-width: 100px; max-height: 100px;"></p>
</th>
</tr>
<tr>
<td><input type="submit" value="Envoyer" name="envoyer"></td>
</tr>
</table>
</form>
</body>
</html>
