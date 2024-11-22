<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient</title>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 120vh;
        margin: 2px;
        background-color: #f0e4d7; /* Couleur de fond douce */
        font-family: Arial, sans-serif;
    }

    form {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        width: 400px;
        margin-top: 50px;
    }

    table {
        width: 100%;
        border-spacing: 20px; /* Espacement entre les champs */
    }

    th {
        text-align: left;
        font-size: 16px;
        color: #4b4b4b;
    }

    input[type="text"], input[type="date"], select {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 14px;
    }

    input[type="submit"] {
        background-color: #4caf50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
        margin-top: 20px;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    select {
        background-color: #f9f9f9;
        padding: 10px;
    }

    /* Style responsive pour petit écran */
    @media (max-width: 768px) {
        form {
            width: 90%;
        }
    }
</style>
<?php include "connexion.php"; ?>
</head>
<body>
    <?php include "Accueil.php"; ?>
    <form method="POST" action="">
        <table>
            <tr><th>Nom</th><th><input type="text" name="nom_pat" required autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th></tr>
            <tr><th>Prénom</th><th><input type="text" name="prenom_pat" required autofocus pattern="[A-Za-zÀ-ÿ\s]{2,20}"></th></tr>
            <tr><th>Date de Naissance</th><th><input type="date" name="date_naissance" required></th></tr>
            <tr><th>Contact ID</th><th><input type="text" name="contact_id" required pattern="[0-9]*"></th></tr>
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
                    $affichagechamb = $bdd->query("SELECT * FROM chambre");
                    while ($datarecup = $affichagechamb->fetch()) {
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
            <tr><th>Employé</th><th>
                <select name="employe" required>
                    <option value="" disabled selected>Sélectionnez un employé</option>
                    <?php
                    $affichagemploye = $bdd->query("SELECT * FROM employe");
                    while ($datarecup = $affichagemploye->fetch()) {
                        echo "<option value='{$datarecup['id_employe']}'>{$datarecup['nom_employe']}</option>";
                    }
                    ?>
                </select>
            </th></tr>
            <tr><td colspan="2"><input type="submit" value="Envoyer" name="envoyer"></td></tr>
        </table>
    </form>
    <?php
    if (isset($_POST["envoyer"])) {
        $recupenom = $_POST["nom_pat"];
        $recupeprenom = $_POST["prenom_pat"];
        $recupdate = $_POST["date_naissance"];
        $recupecontact = $_POST["contact_id"];
        $recupsbloc = $_POST["bloc"];
        $recupchambre = $_POST["chambre"];
        $recupelit = $_POST["lit"];
        $recupeemploye = $_POST["employe"];

        $trouvecontact = $bdd->prepare("SELECT * FROM patient WHERE contact_id = :contact_id");
        $trouvecontact->bindParam(':contact_id', $recupecontact, PDO::PARAM_STR);
        $trouvecontact->execute();

        if ($trouvecontact->rowCount() > 0) {
            echo "<p style='color:red;'>Le contact  existe déjà. Veuillez en choisir un autre.</p>";
        } else {
            try {
                $insertpatient = $bdd->prepare("INSERT INTO patient (nom_pat, prenom_pat, date_naissance, contact_id, id_bloc, id_chambre, id_lit, id_employe) 
                VALUES (:nom_pat, :prenom_pat, :date_naissance, :contact_id, :id_bloc, :id_chambre, :id_lit, :id_employe)");

                $insertpatient->bindParam(':nom_pat', $recupenom);
                $insertpatient->bindParam(':prenom_pat', $recupeprenom);
                $insertpatient->bindParam(':date_naissance', $recupdate);
                $insertpatient->bindParam(':contact_id', $recupecontact);
                $insertpatient->bindParam(':id_bloc', $recupsbloc);
                $insertpatient->bindParam(':id_chambre', $recupchambre);
                $insertpatient->bindParam(':id_lit', $recupelit);
                $insertpatient->bindParam(':id_employe', $recupeemploye);

                $insertpatient->execute();
                echo "<p style='color:green;'>Patient ajouté avec succès.</p>";
            } catch (Exception $e) {
                echo "<p style='color:red;'>Erreur lors de l'ajout du patient : " . $e->getMessage() . "</p>";
            }
        }
    }
    ?>
</body>
</html>
