<?php
include "connexion.php"; 

// Check if the form has been submitted
if (isset($_POST["envoyer"])) {
    // Retrieve form data
    $recuptitre = $_POST["titre"];
    $recupdate = $_POST["date_publication"];
    $recupcontenu = $_POST["contenu"];

    // Image handling
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $image = $_FILES["image"]["name"];
    $image_type = $_FILES["image"]["type"];
    $destination = "Image/" . $image;

    // Validate image type and move file
    if (in_array($image_type, $allowed_types)) {
        $deplacer = move_uploaded_file($_FILES["image"]["tmp_name"], $destination);
        if (!$deplacer) {
            echo "Erreur lors du téléchargement de l'image.";
            exit;
        }
    } else {
        echo "Type de fichier inacceptable, veuillez utiliser (jpeg, png, ou gif).";
        exit;
    }

    // Prepare the update statement
    $modifpublication = $bdd->prepare("UPDATE publication SET titre = :titre, date_publication = :date_publication, contenu = :contenu, image = :image WHERE id_publication = :id_publication");
    
    // Bind parameters
    $modifpublication->bindParam(':titre', $recuptitre);
    $modifpublication->bindParam(':date_publication', $recupdate);
    $modifpublication->bindParam(':contenu', $recupcontenu);
    $modifpublication->bindParam(':image', $image);
    $modifpublication->bindParam(':id_publication', $_GET['Mod'], PDO::PARAM_INT);

    // Execute the query and handle any errors
    try {
        $modifpublication->execute();
        header("location: affichagepublication.php");
        exit; // Ensure no further code is executed after redirection
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}

// Fetch the existing publication data
$affichagepub = $bdd->query("SELECT * FROM publication WHERE id_publication = " . $_GET['Mod']);
$dataRecup = $affichagepub->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 150px;
            padding: 20px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
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
        input[type="text"], input[type="date"] {
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
                <th>Titre</th>
                <td><input type="text" value="<?php echo htmlspecialchars($dataRecup["titre"]); ?>" name="titre" required></td>
            </tr>
            <tr>
                <th>Contenu</th>
                <td><input type="text" value="<?php echo htmlspecialchars($dataRecup["contenu"]); ?>" name="contenu" required></td>
            </tr>
            <tr>
                <th>Date de publication</th>
                <td><input type="date" value="<?php echo htmlspecialchars($dataRecup["date_publication"]); ?>" name="date_publication" required></td>
            </tr>
            <tr>
                <th>Image</th>
                <td><input type="file" name="image" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Envoyer" name="envoyer"></td>
            </tr>
        </table>
    </form>
</body>
</html>
