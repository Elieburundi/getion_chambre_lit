<?php
include "connexion.php"; 
include "Accueil.php"; 

if (isset($_POST["envoyer"])) {
    $recupenum = $_POST["numero_lit"];
    $recupstatut = $_POST["statut"];
    $recupbloc = $_POST["bloc"];
    $recupchambre = $_POST["chambre"];
    $recupimage = $_FILES["image"]["name"];
    $destination = "Image/" . $recupimage;

    // Vérification des doublons
    $verifDoublon = $bdd->prepare("SELECT * FROM lit WHERE numero_lit = :numero_lit");
    $verifDoublon->bindParam(':numero_lit', $recupenum);
    $verifDoublon->execute();

    if ($verifDoublon->rowCount() > 0) {
        echo "<p style='color: red; text-align: center;'>Ce numéro de lit existe déjà.</p>";
    } else {
        // Gestion de l'image
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
            // Insertion du lit s'il n'existe pas déjà
            $insertlit = $bdd->prepare("INSERT INTO lit (numero_lit, statut, id_bloc, id_chambre, image_lit) 
                                         VALUES (:numero_lit, :statut, :id_bloc, :id_chambre, :image_lit)");
            $insertlit->bindParam(':numero_lit', $recupenum);
            $insertlit->bindParam(':statut', $recupstatut);
            $insertlit->bindParam(':id_bloc', $recupbloc);
            $insertlit->bindParam(':id_chambre', $recupchambre);
            $insertlit->bindParam(':image_lit', $recupimage);

            if ($insertlit->execute()) {
                header("Location: affichagelit.php"); // Redirection après insertion
                exit();
            } else {
                echo "<p style='color: red; text-align: center;'>Erreur lors de l'ajout du lit.</p>";
            }
        } else {
            echo "<p style='color: red; text-align: center;'>Erreur lors du téléchargement de l'image.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lit</title>
<style>
    /* Styles pour le formulaire */
    body {
        font-family: Arial, sans-serif;
        background-color: #2e8b8b;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 30;
    }
    .container {
        background-color: #4bafab;
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
    th, td {
        padding: 10px;
        text-align: left;
    }
    input[type="text"], select, input[type="file"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-top: 5px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        width: 100%;
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
                <th>Numéro du lit</th>
                <th><input type="text" name="numero_lit" required pattern="[0-9]*"></th>
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
                        <option value="<?php echo $datarecup["id_bloc"]; ?>">
                            <?php echo $datarecup["nom_bloc"]; ?>
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
                        <option value="" disabled selected>Sélectionnez une chambre</option>
                        <?php
                        $affichagechambre = $bdd->query("SELECT * FROM chambre");
                        while ($datarecup = $affichagechambre->fetch()) {
                        ?> 
                        <option value="<?php echo $datarecup["id_chambre"]; ?>">
                            <?php echo $datarecup["numero"]; ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                </th>
            </tr>
            <tr>
                <th>Image</th>
                <th><input type="file" name="image" required accept="image/*"></th>
            </tr>
            <tr>
                <td><input type="submit" value="Envoyer" name="envoyer"></td>
            </tr>
        </table>
    </form>
</body>
</html>
