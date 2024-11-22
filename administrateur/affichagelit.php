<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Affichage Lit</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f7;
        margin: 40;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    h1 {
        text-align: center;
        color: #333;
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
        margin: 60px ;
        font-size: 16px;
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
        padding: 8px 12px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    a:hover {
        text-decoration: underline;
    }

    td a {
        margin: 0 5px;
    }

    .btn-modifier {
        background-color: #FFA500; /* Couleur pour modifier */
        color: white;
    }

    .btn-supprimer {
        background-color: #FF6347; /* Couleur pour supprimer */
        color: white;
    }

    .btn-modifier:hover {
        background-color: #e68a00; /* Couleur hover pour modifier */
    }

    .btn-supprimer:hover {
        background-color: #e74c3c; /* Couleur hover pour supprimer */
    }

    img {
        max-width: 100px; /* Limite la taille de l'image */
        max-height: 100px;
        border-radius: 4px;
    }
</style>
</head>
<body>
<?php
include "Accueil.php";
include "connexion.php";
?>
<h1>Liste des lits</h1>
<table border=2>
<tr>
<th>Numéro Lit</th>
<th>Statut</th>
<th>Bloc</th>
<th>Chambre</th>
<th>Image</th>
<th colspan="2">Actions</th>
</tr>
<?php 

$affichagelit = $bdd->query("SELECT li.*, bl.nom_bloc, chamb.numero, li.image_lit FROM lit AS li JOIN bloc AS bl ON li.id_bloc = bl.id_bloc JOIN chambre AS chamb ON chamb.id_chambre = li.id_chambre;");

if(isset($_GET["sup"])){
    $supression = $bdd->query("DELETE FROM lit WHERE id_lit='" . $_GET['sup'] . "'");
} 

while($datarecup = $affichagelit->fetch())
{
?>
<tr>
<td><?php echo $datarecup["numero_lit"]; ?></td>
<td><?php echo $datarecup["statut"]; ?></td>
<td><?php echo $datarecup["nom_bloc"]; ?></td>
<td><?php echo $datarecup["numero"]; ?></td>
<td><img src="Image/<?php echo $datarecup["image_lit"]; ?>" alt="Image du lit"></td>
<td><a class="btn-modifier" href="modifielit.php?mod=<?php echo $datarecup["id_lit"]; ?>">Modifier</a></td>
<td><a class="btn-supprimer" href="affichagelit.php?sup=<?php echo $datarecup["id_lit"]; ?>">Supprimer</a></td>
</tr>
<?php
}
?>
</table>
</body>
</html>
