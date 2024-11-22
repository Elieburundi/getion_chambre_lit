<?php
include "connexion.php";
include "Accueil.php";

if (isset($_POST["envoyer"])) {
    $recupenom = $_POST["nom_employe"];
    $recupprenom = $_POST["prenom"];
    $recuprole = $_POST["role"];
    $recupcontact = $_POST["contact"];
    $recupbloc = $_POST["bloc"];
    $recupchambre = $_POST["chambre"];
    $recuplit = $_POST["lit"];

    // Vérification de l'unicité du contact
    $verifContact = $bdd->prepare("SELECT * FROM employe WHERE contact = :contact");
    $verifContact->bindParam(':contact', $recupcontact);
    $verifContact->execute();

    if ($verifContact->rowCount() > 0) {
        echo "<p style='color: red; text-align: center;'>Ce contact est déjà utilisé par un autre employé.</p>";
    } else {
        // Insertion de l'employé si le contact n'existe pas
        $insertemployer = $bdd->prepare("INSERT INTO employe (nom_employe, prenom, rol, contact, id_bloc, id_ch, id_lit) 
            VALUES (:nom_employe, :prenom, :rol, :contact, :id_bloc, :id_ch, :id_lit)");
        $insertemployer->bindParam(':nom_employe', $recupenom);
        $insertemployer->bindParam(':prenom', $recupprenom);
        $insertemployer->bindParam(':rol', $recuprole);
        $insertemployer->bindParam(':contact', $recupcontact);
        $insertemployer->bindParam(':id_bloc', $recupbloc);
        $insertemployer->bindParam(':id_ch', $recupchambre);
        $insertemployer->bindParam(':id_lit', $recuplit);

        if ($insertemployer->execute()) {
            header("Location: affichageemploye.php"); // Redirection après ajout
            exit; // Quitter après redirection
        } else {
            echo "<p style='color: red; text-align: center;'>Erreur lors de l'ajout de l'employé.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employé</title>
<style>
    /* Styles pour le formulaire */
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f4f5;
        margin: 90;
        padding: 20;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 300vh;
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
<body>
<form method="POST" action="#">
<table>
<tr><th>Nom</th><th><input type="text" name="nom_employe" required autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th></tr>
<tr><th>Prénom</th><th><input type="text" name="prenom" required pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th></tr>
<tr><th>Rôle</th><th><input type="text" name="role" required pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th></tr>
<tr><th>Contact</th><th><input type="text" name="contact" required pattern="\+257[0-9]*"></th></tr>
<tr><th>Bloc</th><th>
    <select name="bloc" required>
        <option value="" disabled selected>Sélectionnez un bloc</option>
        <?php
        $affichagebloc = $bdd->query("SELECT * FROM bloc");
        while ($datarecup = $affichagebloc->fetch()) {
            echo "<option value='{$datarecup['id_bloc']}'>{$datarecup['nom_bloc']}</option>";
        }
        ?>
    </select>
</th></tr>
<tr><th>Chambre</th><th>
    <select name="chambre" required>
        <option value="" disabled selected>Sélectionnez une chambre</option>
        <?php
        $affichagechambre = $bdd->query("SELECT * FROM chambre");
        while ($datarecup = $affichagechambre->fetch()) {
            echo "<option value='{$datarecup['id_chambre']}'>{$datarecup['numero']}</option>";
        }
        ?>
    </select>
</th></tr>
<tr><th>Lit</th><th>
    <select name="lit" required>
        <option value="" disabled selected>Sélectionnez un lit</option>
        <?php
        $affichagelit = $bdd->query("SELECT * FROM lit");
        while ($datarecup = $affichagelit->fetch()) {
            echo "<option value='{$datarecup['id_lit']}'>{$datarecup['numero_lit']}</option>";
        }
        ?>
    </select>
</th></tr>
<tr><td colspan="2"><input type="submit" value="Envoyer" name="envoyer"></td></tr>
</table>
</form>
</body>
</html>
