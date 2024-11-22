<?php
include "connexion.php"; 
include "Accueil.php";

if (isset($_POST["envoyer"])) {
    $recupnumero = $_POST["numero"];
    $recuptype = $_POST["type"];
    $recupstatut = $_POST["statut"];
    $recupbloc = $_POST["bloc"];
    $recupimage = $_FILES["image_chambre"]["name"];
    $destination = "Image/" . basename($recupimage);

    // Vérification des doublons
    $verifDoublon = $bdd->prepare("
        SELECT * FROM chambre 
        WHERE numero = :numero 
        AND type = :type 
        AND statut = :statut
        AND id_bloc = :id_bloc
    ");
    
    // Lier les paramètres
    $verifDoublon->bindParam(':numero', $recupnumero);
    $verifDoublon->bindParam(':type', $recuptype);
    $verifDoublon->bindParam(':statut', $recupstatut);
    $verifDoublon->bindParam(':id_bloc', $recupbloc); 

    $verifDoublon->execute();

    if ($verifDoublon->rowCount() > 0) {
        echo "Cette chambre existe déjà.";
    } else {
        // Gestion de l'upload d'image
        if (isset($_FILES['image_chambre']) && $_FILES['image_chambre']['error'] == UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image_chambre']['tmp_name'];
            $imageName = $_FILES['image_chambre']['name'];
            $imagePath = '' . basename($imageName); // Dossier de destination

            // Déplacer le fichier uploadé
            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                // Insertion de la chambre
                $insertchambre = $bdd->prepare("
                    INSERT INTO chambre (numero, type, statut, id_bloc, image_chambre) 
                    VALUES (:numero, :type, :statut, :id_bloc, :image_chambre)
                ");
                
                // Lier les paramètres pour l'insertion
                $insertchambre->bindParam(':numero', $recupnumero);
                $insertchambre->bindParam(':type', $recuptype);
                $insertchambre->bindParam(':statut', $recupstatut);
                $insertchambre->bindParam(':id_bloc', $recupbloc);
                $insertchambre->bindParam(':image_chambre', $imagePath);

                if ($insertchambre->execute()) {
                    echo "Chambre ajoutée avec succès.";
                    header("Location: affichagechambre.php"); 
                    exit; 
                } else {
                    echo "Erreur lors de l'ajout de la chambre : " . implode(", ", $insertchambre->errorInfo());
                }
            } else {
                echo "Erreur lors de l'upload de l'image.";
            }
        } else {
            echo "Aucune image n'a été uploadée.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chambre</title>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 40;
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

    select {
        background-color: #f9f9f9;
        padding: 10px;
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
    <h1>Chambre</h1>
    <table>
        <tr>
            <th>Numéro</th>
            <th><input type="text" name="numero" required autofocus pattern="[0-9]*"></th>
        </tr>
        <tr>
            <th>Type</th>
            <th><input type="text" name="type" required pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th>
        </tr>
        <tr>
            <th>Statut</th>
            <th><input type="text" name="statut" required pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th>
        </tr>
        <tr>
            <th>Bloc</th>
            <th>
                <select name="bloc" required>
                    <option value="" disabled selected>Sélectionnez un bloc</option>
                    <?php
                    $affichagebloc = $bdd->query("SELECT * FROM bloc");
                    while ($datarecup = $affichagebloc->fetch()) {
                    ?> 
                        <option value="<?php echo $datarecup["id_bloc"];?>">
                            <?php echo $datarecup["nom_bloc"]; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </th>
        </tr>
        <tr>
            <th>Image</th>
            <th><input type="file" name="image_chambre" accept="image/*" required></th>
        </tr>
        <tr>
            <td><input type="submit" value="Envoyer" name="envoyer"></td>
        </tr>
    </table>
</form>

</body>
</html>
