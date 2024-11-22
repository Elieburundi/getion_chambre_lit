
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>modifie_patient</title>
<?php
include "connexion.php"; 
include "Accueil.php";
$affichagepatient = $bdd->query("select * from patient as pt join bloc as bl on pt.id_bloc= bl.id_bloc join chambre as chamb on pt.id_chambre=chamb.id_chambre join lit as lt on pt.id_lit=lt.id_lit join employe as empl on pt.id_employe=empl.id_employe where id_patient='".$_GET['mod']."'");
$datarecup= $affichagepatient->fetch();
if(isset($_POST["envoyer"])){
$recupenom=$_POST["nom_pat"];
$recupeprenom=$_POST["prenom_pat"];
$recupdate=$_POST["date_naissance"];
$recupecontact=$_POST["contact_id"];
$recupsbloc=$_POST["bloc"];
$recupchambre=$_POST["chambre"];
$recupelit=$_POST["lit"];
$recupeemploye=$_POST["employe"];

$modifpatient= "update patient set nom_pat='$recupenom',prenom_pat='$recupeprenom',date_naissance='$recupdate',contact_id='$recupecontact',id_bloc='$recupsbloc',id_chambre='$recupchambre',id_lit='$recupelit',id_employe='$recupeemploye' where id_patient='".$_GET['mod']."'";
$bdd->exec($modifpatient);
header("location:affichagepatient.php");
}
?>
 <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 100px;
        padding: 60;
    }

    .container {
        max-width: 400px; /* Réduire la largeur du conteneur */
        margin: 50px auto;
        background-color: #fff;
        padding: 10px; /* Diminuer le padding */
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
        font-size: 1em;
    }

    table {
        width: 100%; /* Garder la largeur à 100% mais dans un conteneur plus petit */
        margin-top: 20px;
        border-collapse: collapse; /* Supprimer les espaces entre les cellules */
    }

    th {
        text-align: left;
        padding: 4px; /* Diminuer le padding */
        color: #555;
    }

    td {
        padding: 4px; /* Diminuer le padding des cellules */
    }

    input[type="text"], input[type="date"], select {
        width: 40%;
        padding: 1px; /* Diminuer le padding */
        margin-top: 1px;
        border: 1px solid #ccc;
        border-radius: 2px;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus, input[type="date"]:focus, select:focus {
        border-color: #007bff;
        outline: none;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px; /* Diminuer le padding */
        border-radius: 2px;
        cursor: pointer;
        transition: background-color 0.3s;
        width: 30%;
        margin-top: 20px;
        
    }

    input[type="submit"]:hover {
        background-color: green;
    }
     
      
</style>


</head>
<body>
<form method="POST" action="">
<table>
<tr>
<th>nom</th>
<th><input type="text" value="<?php echo $datarecup["nom_pat"]?>" name="nom_pat" required></th>
</tr>
<tr>
<th>prenom</th>
<th><input type="text" value="<?php echo $datarecup["prenom_pat"]?>" name="prenom_pat" required></th>
</tr>
<th>date_naissance</th>
<th><input type="date"value="<?php echo $datarecup["date_naissance"]?>" name="date_naissance" required></th>
</tr>
<th>contact_id</th>
<th><input type="text"value="<?php echo $datarecup["contact_id"]?>" name="contact_id" required></th>
</tr>
<tr>
  <th>bloc</th>
  <th>
            <select name="bloc" required>
            <option value="" disabled selected>Sélectionnez un bloc</option>
            <?php
            $affichagebloc = $bdd->query("select * from bloc");
            while ($datarecup = $affichagebloc->fetch()) {
            ?> 
            <option value="<?php echo $datarecup["id_bloc"];?>">
            <?php echo $datarecup["nom_bloc"]; ?>
            </option>
            <?php
            }
            ?>
            </select>
  </th>
</tr>
<tr>
  <th>chambre</th>
  <th>
            <select name="chambre" required>
            <option value="" disabled selected>Sélectionnez une chambre</option>
            <?php
            $affichagechamb = $bdd->query("select * from chambre");
            while ($datarecup = $affichagechamb->fetch()) {
            ?> 
            <option value="<?php echo $datarecup["id_chambre"];?>">
            <?php echo $datarecup["numero"]; ?>
            </option>
            <?php
            }
            ?>
            </select>
  </th>
</tr>
<tr>
  <th>lit</th>
  <th>
            <select name="lit" required>
            <option value="" disabled selected>Sélectionnez un lit</option>
            <?php
            $affichagelit = $bdd->query("select * from lit");
            while ($datarecup = $affichagelit->fetch()) {
            ?> 
            <option value="<?php echo $datarecup["id_lit"];?>">
            <?php echo $datarecup["numero_lit"]; ?>
            </option>
            <?php
            }
            ?>
            </select>
  </th>
</tr>
<tr>
  <th>employe</th>
  <th>
            <select name="employe" required>
            <option value="" disabled selected>Sélectionnez un employe</option>
            <?php
            $affichagemploye = $bdd->query("select * from employe");
            while ($datarecup = $affichagemploye->fetch()) {
            ?> 
            <option value="<?php echo $datarecup["id_employe"];?>">
            <?php echo $datarecup["nom_employe"]; ?>
            </option>
            <?php
            }
            ?>
            </select>
  </th>
</tr>
<tr>
<td><input type="submit" value="Envoyer" name="envoyer"></td>
</tr>
</table>
</form>

</body>
</html>

