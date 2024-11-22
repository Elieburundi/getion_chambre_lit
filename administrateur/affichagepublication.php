<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Publications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f7;
            margin: 100px;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            color: green;
            margin-bottom: 20px;
            font-size: 24px;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            max-width: 1200px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            font-size: 16px;
        }

        th, td {
            padding: 12px 20px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        td {
            color: #333;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        td a {
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-modifier {
            background-color: #FFA500;
        }

        .btn-supprimer {
            background-color: #FF6347;
        }

        .image-preview {
            max-width: 150px; /* Limite la largeur de l'image */
            max-height: 100px; /* Limite la hauteur de l'image */
            object-fit: cover; /* Garde le ratio d'aspect et couvre le conteneur */
            border-radius: 5px; /* Arrondit les coins de l'image */
        }
    </style>
    
    <?php 
        include "Connexion.php";
        $affichagePub = $bdd->query("SELECT * FROM publication ORDER BY id_publication DESC");

        if (isset($_GET["sup"])) {
            $suppressionPub = $bdd->query("DELETE FROM publication WHERE id_publication=" . $_GET['sup']);
        }

        include "Accueil.php";
    ?>
</head>
<body>
    <div class="container">
        <table>
            <tr>
                <th>Titre</th>
                <th>Date de Publication</th>
                <th>Contenu</th>
                <th>Image</th>
                <th colspan="2">Actions</th>
            </tr>
            <?php while ($dataRecup = $affichagePub->fetch()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($dataRecup["titre"]); ?></td>
                    <td><?php echo htmlspecialchars($dataRecup["date_publication"]); ?></td>
                    <td><?php echo htmlspecialchars($dataRecup["contenu"]); ?></td>
                    <td>
                        <?php if (!empty($dataRecup["image"])): ?>
                            <img src="Image/<?php echo htmlspecialchars($dataRecup["image"]); ?>" alt="Image de la publication" class="image-preview">
                        <?php else:?>
                            Pas d'image
                        <?php endif;?>
                    </td>
                    <td><a href="affichagepublication.php?sup=<?php echo $dataRecup["id_publication"]; ?>" class="btn-supprimer">Supprimer</a></td>
                    <td><a href="modifiepublication.php?Mod=<?php echo $dataRecup["id_publication"]; ?>" class="btn-modifier">Modifier</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
