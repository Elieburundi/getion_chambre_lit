<?php
include "Accueil.php";
include "connexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>affichage_employe</title>
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
</head>
<body>


<table border=2 left=10px>
<tr>
<th>nom</th>
<th>prenom</th>
<th>role</th>
<th>Contact</th>
<th>bloc</th>
<th>numero chambre</th>
<th>numero lit</th>
<th colspan="2">actions</th>
</tr>
<?php 


$affichageemploye = $bdd->query("select * from employe as emp join bloc as bl on emp.id_bloc= bl.id_bloc join lit as li on emp.id_lit=li.id_lit join chambre as ch on ch.id_chambre=emp.id_ch;");


if(isset($_GET["sup"])){
$supressionchambre=$bdd->query("delete from employe where id_employe='".$_GET['sup']."'");
} 

while($datarecup=$affichageemploye->fetch())
{
?>
<tr>
<td><?php echo $datarecup["nom_employe"]?></td>
<td><?php echo $datarecup["prenom"]?></td>
<td><?php echo $datarecup["rol"]?></td>
<td><?php echo $datarecup["contact"]?></td>
<td><?php echo $datarecup["nom_bloc"]?></td>
<td><?php echo $datarecup["numero"]?></td>
<td><?php echo $datarecup["numero_lit"]?></td>
<td><a href="modify_employer.php?mod=<?php echo $datarecup["id_employe"]; ?>">Modifier</a></td>
<td><a href="affichageemploye.php?sup=<?php echo $datarecup["id_employe"]; ?>">supprimer</a></td>
</tr>
<?php
}
?>
</table>
</body>
</html>

