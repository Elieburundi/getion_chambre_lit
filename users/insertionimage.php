<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php include 'Accueil.php';?>;
<form method="POST" enctype="multipart/form-data">
    telecharger un fichier
     <br>
     <input type="file" name="fichier"
     id="filerToUload">
     <br>
     <br>
     <input type="submit" value="Telecharger"
     name="submit">
     <br>

    
</body>
</html>
<?php
If( !empty($_FILES)){
$recuperenom=$_FILES["fichier"]["name"] ;
$recupereprenom=$_FILES["fichier"]["name"] ;
$recupereextension=strrchr($recuperenom, ".") ;
$extension_autorisees=array(".pdf",".PDF",".png",".PNG") ;
If(in_array($recupereextension, $extension_autorisees)){
}
else
{
echo"seuls fichiers pdf et png sont autorisees";
}
}