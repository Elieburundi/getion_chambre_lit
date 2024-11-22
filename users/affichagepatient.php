<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>affichage_patient</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 10px;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 10px;
        font-size: 24px;
    }

    table {
        width: 40%;
        border-collapse: collapse;
        margin: 0;
        font-size: 18px;
        position: absolute;
        text-align: center;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    a {
        color: #4CAF50;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    td:last-child {
        text-align: center;
    }

    .actions {
        display: flex;
        justify-content: space-evenly;
    }

    button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #d32f2f;
    }
</style>
</head>
<body>
<?php
include "Accueil.php";
include "connexion.php";
?>
<?php
if(isset($_POST["envoyer"])){
$recupenom=$_POST["nom_pat"];
$recupeprenom=$_POST["prenom_pat"];
$recupdate=$_POST["date_naissance"];
$recupecontact=$_POST["contact_id"];
$recupsbloc=$_POST["bloc"];
$recupchambre=$_POST["chambre"];
$recupelit=$_POST["lit"];
$recupeemploye=$_POST["employe"];

$insertpatient="insert into patient(nom_pat,prenom_pat,date_naissance,contact_id,id_bloc,id_chambre,id_lit,id_employe) values ('$recupenom','$recupeprenom','$recupdate','$recupecontact','$recupsbloc','$recupchambre','$recupelit','$recupeemploye')";
$bdd->exec($insertpatient);
//header("location:affichagepatient.php");
}
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
</tr>
<?php
}
?>
</table>
</body>
</html>