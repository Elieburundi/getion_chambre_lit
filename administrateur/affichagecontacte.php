<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage Contactes</title>
    <style>   
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
.container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 900px;
    width: 100%;
}
h1 {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

/* Table Styles */
table {
    width: 10%;
    border-collapse: collapse;
    margin-bottom: 2px;
}

th, td {
    padding: 10px 12px;  /* Reduced padding for tighter spacing */
    text-align: left;
    border-bottom: 1px ;
}

th {
    background-color: #4CAF50;
    color: white;
    text-transform: uppercase;
}

td {
    color: #555;
}

/* Adjusting column widths */
td:nth-child(6) {
    width: 30%; /* Message column */
}

td:nth-child(7) {
    width: 1%; /* Actions column */
    text-align: center; /* Center align actions */
}

td p {
    margin: 0;
    word-wrap: break-word; /* Ensure long messages break onto new lines */
}

tr:hover {
    background-color: #f1f1f1;
}

/* Action Buttons */
td a {
    background-color: #ff4d4d;
    color: white;
    padding: 6px 10px;  /* Slightly reduced padding */
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
    display: inline-block;
}

td a:hover {
    background-color: #ff3333;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    th, td {
        padding: 8px;
        font-size: 14px;
    }

    td p {
        width: 100%;
    }

    .container {
        width: 95%;
    }
}
</style>
    <?php 
        include "Connexion.php" ;
        $affichageContact = $bdd->query("Select * from Contacted order by id_cont DESC");
    ?>

    <?php
        if(isset($_GET["sup"])){
            $suppressionCont = $bdd->query("delete from Contacted where id_cont=".$_GET['sup']);
            
        }
    ?>

    <?php include "Accueil.php" ?>
</head> 
<body>
    <div class="container">
    
        <h1>Contactez_nous</h1>
        <table>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Adresse</th>
                <th>Telephone</th>
                <th>Objet</th>
                <th>Message</th>
                <th colspan="2">Actions</th>
            </tr>
            <?php 
                while ( $dataRecup = $affichageContact->fetch()) {         
            ?>
                <tr>
                    <td ><?php echo $dataRecup["nom"]; ?></td>
                    <td><?php echo $dataRecup["prenom"]; ?></td>
                    <td><?php echo $dataRecup["adresse"]; ?></td>
                    <td ><?php echo $dataRecup["telephone"]; ?></td>
                    <td><?php echo $dataRecup["objet"]; ?></td>
                    <td><p style="width: 400px;"><?php echo $dataRecup["message"]; ?></p></td>
                    <td><a href="affichagecontacte.php?sup=<?php echo $dataRecup["id_cont"]; ?>">Supprimer</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>