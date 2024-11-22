<?php
include "Accueil.php";
include "connexion.php";

function fetchBlocById($bdd, $id) {
    $stmt = $bdd->prepare("SELECT * FROM facture WHERE id_facture = :id_facture");
    $stmt->bindParam(':id_facture', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateBloc($bdd, $id, $type_facture, $date_paye, $nom, $prenom, $motif) {
    $stmt = $bdd->prepare("UPDATE facture SET type_facture = :type_facture, date_paye = :date_paye, nom = :nom, prenom = :prenom, motif = :motif WHERE id_facture = :id_facture");
    $stmt->bindParam(':id_facture', $id, PDO::PARAM_INT);
    $stmt->bindParam(':type_facture', $type_facture, PDO::PARAM_STR);
    $stmt->bindParam(':date_paye', $date_paye, PDO::PARAM_STR);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindParam(':motif', $motif, PDO::PARAM_STR);
    return $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $bloc = fetchBlocById($bdd, $id);
    
    if (!$bloc) {
        echo '<div>Facture non trouvée.</div>';
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
    $id = filter_input(INPUT_POST, 'id_facture', FILTER_SANITIZE_NUMBER_INT);
    $type_facture = filter_input(INPUT_POST, 'type_facture', FILTER_SANITIZE_STRING);
    $date_paye = filter_input(INPUT_POST, 'date_facture', FILTER_SANITIZE_STRING);
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
    $motif = filter_input(INPUT_POST, 'motif', FILTER_SANITIZE_STRING);
    
    if (updateBloc($bdd, $id, $type_facture, $date_paye, $nom, $prenom, $motif)) {
        header("Location: affichage_facture.php");
        exit;
    } else {
        echo '<div>Erreur lors de la modification de la facture.</div>';
    }
    
    $bloc = fetchBlocById($bdd, $id);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification des factures</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 3px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Modifier Facture</h1>

    <?php if (isset($bloc)): ?>
    <form method="POST" action="">
        <input type="hidden" name="id_facture" value="<?php echo htmlspecialchars($bloc['id_facture']); ?>">
        <div>
            <label for="type_facture">Type de Facture :</label>
            <input type="text" id="type" name="type_facture" value="<?php echo htmlspecialchars($bloc['type_facture']); ?>" required>
        </div>
        <div>
            <label for="date_facture">Date de Facture :</label>
            <input type="date" id="date" name="date_facture" value="<?php echo htmlspecialchars($bloc['date_paye']); ?>" required>
        </div>
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($bloc['nom']); ?>" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($bloc['prenom']); ?>" required>
        </div>
        <div>
            <label for="motif">Motif :</label>
            <input type="text" id="motif" name="motif" value="<?php echo htmlspecialchars($bloc['motif']); ?>" required>
        </div>
        <div>
            <button type="submit" name="modifier">Modifier</button>
        </div>
    </form>
    <?php else: ?>
    <div class="message">Aucune facture sélectionnée pour modification.</div>
    <?php endif; ?>

</body>
</html>
