<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Affichage Chambres</title>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50vh;
        margin: 180px;
        background-color: cyan;
        font-family: Arial, sans-serif;
    }

    table {
        width: 50%;
        border-collapse: collapse;
        margin-top: 20px;
        text-align: left;
        background-color: white;
    }

    th, td {
        padding: 12px;
        border: 1px solid black;
        text-align: center;
    }

    th {
        background-color: darkcyan;
        color: white;
    }

    td a {
        text-decoration: none;
        color: blue;
        font-weight: bold;
    }

    td a:hover {
        color: red;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: lightgray;
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        table {
            width: 90%; /* Changer à 90% pour un meilleur ajustement */
        }

        body {
            margin: 20px;
            height: auto;
        }
    }
</style>
</head>
<body>   
<?php
include "Accueil.php";
include "connexion.php";
?>

<table>
<tr>
<th>Numéro</th>
<th>Type</th>
<th>Statut</th>
<th>Bloc</th>
<th>Image</th>
<th colspan="2">Actions</th>
</tr>

<?php
// Afficher les chambres avec une jointure
$affichagechambre = $bdd->query("
    SELECT ch.*, bl.nom_bloc 
    FROM chambre AS ch 
    JOIN bloc AS bl ON ch.id_bloc = bl.id_bloc
");

if(isset($_GET["sup"])){
    // Utilisation d'une requête préparée pour supprimer une chambre
    $supressionchambre = $bdd->prepare("DELETE FROM chambre WHERE id_chambre = :id");
    $supressionchambre->bindParam(':id', $_GET['sup']);
    $supressionchambre->execute();
}

while($datarecup = $affichagechambre->fetch()) {
?>
<tr>
<td><?php echo htmlspecialchars($datarecup["numero"]); ?></td>
<td><?php echo htmlspecialchars($datarecup["type"]); ?></td>
<td><?php echo htmlspecialchars($datarecup["statut"]); ?></td>
<td><?php echo htmlspecialchars($datarecup["nom_bloc"]); ?></td>
<td><img src="<?php echo htmlspecialchars($datarecup['image_chambre']); ?>" alt="Image de la chambre" style="width: 100px; height: auto;"></td>
<td><a href="modifiechambre.php?mod=<?php echo $datarecup["id_chambre"]; ?>">Modifier</a></td>
<td><a href="affichagechambre.php?sup=<?php echo $datarecup["id_chambre"]; ?>">Supprimer</a></td>
</tr>
<?php
}
?>
</table>
</body>
</html>

