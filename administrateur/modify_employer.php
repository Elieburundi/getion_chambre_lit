
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>employe</title>
<?php
include "Accueil.php";
include "connexion.php"; 
$affichageemploye = $bdd->query("select * from employe as emp join bloc as bl on emp.id_bloc= bl.id_bloc join lit as li on emp.id_lit=li.id_lit join chambre as ch on ch.id_chambre=emp.id_ch where id_employe='".$_GET['mod']."'");
$datarecup=$affichageemploye->fetch();
if(isset($_POST["envoyer"])){
$recupenom=$_POST["nom_employe"];
$recupprenom=$_POST["prenom"];
$recuprole=$_POST["role"];
$recupcontact=$_POST["contact"];
$recupbloc=$_POST["bloc"];
$recupchambre=$_POST["chambre"];
$recuplit=$_POST["lit"];


$modemployer="UPDATE employe set nom_employe='$recupenom',prenom='$recupprenom',rol='$recuprole',contact='$recupcontact',id_bloc='$recupbloc',id_ch='$recupchambre',id_lit='$recuplit' where id_employe='".$_GET['mod']."'";
$bdd->exec($modemployer);
header("location: affichageemploye.php");
}
?>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f4f5;
        margin: 80px;
        padding: 2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    form {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
        width: 400px;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
        font-size: 24px;
    }

    table {
        width: 100%;
        border-spacing: 10px;
    }

    th {
        text-align: left;
        font-size: 16px;
        color: #333;
    }

    input[type="text"], select {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-top: 20pxpx;
        margin-bottom: 15px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
<form method="POST" action="">
<table>
<tr>
<th>nom</th>
<th><input type="text" value=<?php echo $datarecup["nom_employe"]; ?> name="nom_employe" require autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th>
</tr>
<th>prenom</th>
<th><input type="text" value=<?php echo $datarecup["prenom"]; ?> name="prenom" require pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th>
</tr>
<th>role</th>
<th><input type="text"value=<?php echo $datarecup["rol"]; ?> name="role" require pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th>
</tr>
<th>contact</th>
<th><input type="text"value=<?php echo $datarecup["contact"]; ?> name="contact" require pattern="\+257[0-9]*"></th>
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
                    $affichagechambre = $bdd->query("select * from chambre");
                    while ($datarecup = $affichagechambre->fetch()) {
                    ?> 
                    <option value="<?php echo $datarecup["id_chambre"]; ?>" >
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
                    <option value="<?php echo $datarecup["id_lit"]; ?>" >
                    <?php echo $datarecup["numero_lit"]; ?>
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

