<?php  
include "Accueil.php";

if (isset($_POST["Envoyer"])) {
    try {
        // Database connection
        $bdd = new PDO('mysql:host=localhost;dbname=chambre_lit;charset=utf8', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Image handling
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $image = $_FILES["image"]["name"];
        $image_type = $_FILES["image"]["type"];
        $destination = "Image/" . $image;

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

        // Inserting data into the database
        $stmt = $bdd->prepare("INSERT INTO publication (titre, date_publication, contenu, image) VALUES (:titre, :date_publication, :contenu, :image)");
        $stmt->execute([
            ':titre' => $_POST["titre"],
            ':date_publication' => $_POST["date_publication"],
            ':contenu' => $_POST["contenu"],
            ':image' => $image
        ]);

        echo "<p>Publication ajoutée avec succès!</p>";
    } catch (PDOException $e) {
        echo "<p>Erreur : " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création des publications</title>
    <p><img src="choix.jpg" height="400px" width="1700px"> </p>
</head>
<body bgcolor="chocolate">
    <div>
        <section>
            <h2>Publier un message</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="titre">Titre</label>
                    <input type="text" name="titre" id="titre" required autofocus>
                </div>
                <div>
                    <label for="date_publication">Date de publication</label>
                    <input type="date" name="date_publication" id="date_publication" required>
                </div>
                <div>
                    <label for="contenu">Contenu</label>
                    <textarea name="contenu" id="contenu" rows="5"></textarea>
                </div>
                <div>
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" required>
                </div>
                <div>
                    <input type="submit" name="Envoyer" value="Publier">
                </div>
            </form>
        </section>
    </div>
</body>
</html>
