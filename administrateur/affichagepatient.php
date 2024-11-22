<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>affichage_patient</title>
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
<?php
include "Accueil.php";
include "connexion.php";
?>

<table border=2 left=10px>
<tr>
<th>nom</th>
<th>prenom</th>
<th>date_naissance</th>
<th>contact_id</th>
<th>bloc</th>
<th>chambre</th>
<th>lit</th>
<th>employe</th>
<th colspan="2">actions</th>
</tr>
<?php 

$affichagepatient = $bdd->query("select * from patient as pt join bloc as bl on pt.id_bloc= bl.id_bloc join chambre as chamb on pt.id_chambre=chamb.id_chambre join lit as lt on pt.id_lit=lt.id_lit join employe as empl on pt.id_employe=empl.id_employe ;");


if(isset($_GET["sup"])){
$supression=$bdd->query("delete from patient where id_patient='".$_GET['sup']."'");
} 

while($datarecup=$affichagepatient->fetch())
{
?>
<tr>
<td><?php echo $datarecup["nom_pat"]?></td>
<td><?php echo $datarecup["prenom_pat"]?></td>
<td><?php echo $datarecup["date_naissance"]?></td>
<td><?php echo $datarecup["contact_id"]?></td>
<td><?php echo $datarecup["nom_bloc"]?></td>
<td><?php echo $datarecup["numero"]?></td>
<td><?php echo $datarecup["numero_lit"]?></td>
<td><?php echo $datarecup["nom_employe"]?></td>
<td><a href="ModifiePatient.php?mod=<?php echo $datarecup["id_patient"]; ?>">Modifier</a></td>
<td><a href="affichagepatient.php?sup=<?php echo $datarecup["id_patient"]; ?>">supprimer</a></td>
</tr>
<?php
}
?>
</table>
</body>
</html>