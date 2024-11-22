<?php
include "Accueil.php";
$message = ""; // Initialiser la variable pour le message de succès

if (isset($_POST["Enregistrer"])) {
    $type_facture = $_POST['type_facture'];
    $date_paye = $_POST['date_paye'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $motif = $_POST['motif'];
   

    try {
        include "connexion.php";

        $stmt = $bdd->prepare("INSERT INTO facture (type_facture, date_paye, nom, prenom, motif) 
                               VALUES (:type_facture, :date_paye, :nom, :prenom, :motif )");

        $stmt->bindParam(':type_facture', $type_facture);
        $stmt->bindParam(':date_paye', $date_paye);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':motif', $motif);
        // $stmt->bindParm(':id_employe',$employe);

        $stmt->execute();
        header("location:affichage_facture.php");
        $message = "Facture enregistrée avec succès"; // Définir le message de succès
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            margin: 10;
            height: 150vh;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px 25px;
            width: 100%;
            max-width: 450px; /* Taille réduite du formulaire */
            margin: auto;
        }
        h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 28px;
            color: #343a40;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #495057;
            font-weight: 500;
        }
        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 8px 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            box-sizing: border-box;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        input[type="text"]:focus, input[type="date"]:focus {
            outline: none;
            border-color: #80bdff;
            box-shadow: 0 0 0 2px rgba(128, 189, 255, 0.3);
        }
        button {
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        button[type="submit"] {
            background-color: #28a745;
            color: white;
            margin-right: 8px;
        }
        button[type="submit"]:hover {
            background-color: #218838;
        }
        #printBtn {
            background-color: #007bff;
            color: white;
        }
        #printBtn:hover {
            background-color: #0056b3;
        $message{
            color:green;
        }
        }
    </style>
    <script>
        function imprimerFacture() {
            window.print();
        }
    </script>
</head>
<body>
    <!-- <h2>Facture</h2> -->
    <?php if ($message) : ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <div class="form-container">
        <form action="" method="post">
            <div class="form-group">
                <label for="type_facture">Type de Facture</label>
                <input type="text" id="type_facture" name="type_facture" required>
            </div>
            <div class="form-group">
                <label for="date_paye">Date de Paiement</label>
                <input type="date" id="date_paye" name="date_paye" required>
            </div>
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="motif">Motif de Paiement</label>
                <input type="text" id="motif" name="motif" required>
            </div>
    
            <button type="submit" name="Enregistrer">Enregistrer</button>
            <button type="button" id="printBtn" onclick="imprimerFacture()">Imprimer</button>
        </form>
    </div>
</body>
</html>
