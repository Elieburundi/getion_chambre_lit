<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage Contactez_nous</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f7;
        margin: 50;
        padding: 10;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
        font-size: 24px;
    }

    table {
        border-collapse: collapse;
        width: 50%;
        max-width: 1200px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 70px 0;
        font-size: 16px;
        table:center:
    }

    th, td {
        padding: 12px 20px;
        text-align: left;
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

    td a:hover {
        background-color: #007BFF;
        color: white;
    }

    .btn-modifier {
        background-color: #FFA500;
    }

    .btn-supprimer {
        background-color: #FF6347;
    }
</style>
    <?php 
        include "Connexion.php" ;
        $affichageAdmin = $bdd->query("Select * from administrateur");
    ?>

    <?php
        if(isset($_GET["sup"])){
            $suppressionAdmin = $bdd->query("delete from administrateur where id_admin=".$_GET['sup']);
            
        }
    ?>

    <?php include "Accueil.php" ?>
</head>
<body> 
    <div class="container">
        <table>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th colspan="2">Actions</th>
            </tr>
            <?php 
                while ( $dataRecup = $affichageAdmin->fetch()) {         
            ?>
                <tr>
                    <td ><?php echo $dataRecup["username"]; ?></td>
                    <td><?php echo md5($dataRecup["password"]); ?></td>
                    <td><a href="affichageadmin.php?sup=<?php echo $dataRecup["id_admin"]; ?>">Supprimer</a></td>
                    <td><a href="modifieadmin.php?mod=<?php echo $dataRecup["id_admin"]; ?>">Modifier</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>