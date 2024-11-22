<html>
<head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2e8b8b; /* Couleur de fond */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Remplir toute la hauteur de la fenêtre */
            color: #fff; /* Couleur du texte */
        }
        
        .container {
            background-color: #4bafab; /* Couleur de fond du formulaire */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 500px; /* Largeur maximale du formulaire */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: aqua; /* Couleur du titre */
        }

        table {
            width: 100%; /* Prendre toute la largeur du conteneur */
            border-collapse: collapse; /* Éliminer les espaces entre les cellules */
        }

        th {
            text-align: left;
            padding: 10px;
        }

        td {
            padding: 10px;
        }

        input[type="text"] {
            width: 100%; /* Largeur de l'input */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 5px;
            box-sizing: border-box; /* Inclure le padding dans la largeur */
        }

        input[type="submit"], input[type="reset"] {
            background-color: #007BFF; /* Couleur de fond du bouton */
            color: white; /* Couleur du texte */
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer; /* Changer le curseur lors du survol */
            margin-top: 10px; /* Espacement supérieur */
        }

        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #0056b3; /* Couleur de fond au survol */
        }

        .error {
            color: red; /* Couleur pour les messages d'erreur */
            text-align: center;
        }
    </style>
</head>
<body bgcolor="green"> 
<?php
include"connexion.php";
include"Accueil.php";
$affichageRecl = $bdd->query("Select * from contact");
?> 
<meta charset="utf_8"/>
</head>
<body>

<form method="POST" action="affichagecontacte.php">
<table>


<tr> <th>nom_contact</th>
<td> <input type="text" name="nom_contact" require autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}"/></td>
</tr>
<tr> <th>relation</th>
<td> <input type="text" name="relation" require pattern="[A-Za-zÀ-ÿ\s]{2,20}"/> </td>
</tr>
<tr> <th>telephone</th>
<td> <input type="text" name="telephone" require pattern="[0-9]*"/> </td>
</tr>

<tr> <th> </th>
<td> <input type="submit" name="envoyer" value ="enregistrer"/>
   <!-- <input type="reset" value="supprimer"/> -->
   </td>
 </tr>
 </table>
 </from>

</body>
</html>
<?php
if(isset($_POST["envoyer"]))
{

$recupnom=$_POST["nom_contact"];
$recuprole=$_POST["relation"];
$recuppcontact=$_POST["telephone"];
$trouvecontact = $bdd->prepare("Select * from contact where telephone= :telephone");
$trouvecontact->bindParam(':telephone', $recuppcontact, PDO::PARAM_STR);
$trouvecontact->execute();
if($trouvecontact->rowCount() > 0){
    echo "ce contact existe deja";
    }
    else{
      $updateEmploye ="update contact set nom_contact:'$recupnom',relation:'$recuprole',telephone:'$recuppcontact'";
      $bdd->exec($updateEmploye ); 
      //header("location:affichagecontacte.php");
    }
}
?>


<style>
h1,h2{
	color:aqua;

</style>


</body>
</html>