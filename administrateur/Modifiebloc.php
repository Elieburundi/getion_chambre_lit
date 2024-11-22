<?php
include "Accueil.php";
include "connexion.php";

function fetchBlocById($bdd, $id) {
    $stmt = $bdd->prepare("SELECT * FROM bloc WHERE id_bloc = :id_bloc");
    $stmt->bindParam(':id_bloc', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateBloc($bdd, $id, $nom, $description) {
    $stmt = $bdd->prepare("UPDATE bloc SET nom_bloc = :nom, description = :description WHERE id_bloc = :id_bloc");
    $stmt->bindParam(':id_bloc', $id, PDO::PARAM_INT);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    return $stmt->execute();
    
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $bloc = fetchBlocById($bdd, $id);
    
    if (!$bloc) {
        echo '<div>Bloc non trouvé.</div>';
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
    $id = filter_input(INPUT_POST, 'id_bloc', FILTER_SANITIZE_NUMBER_INT);
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    
    if (updateBloc($bdd, $id, $nom, $description)) {
        header("Location: affichagebloc.php");
        echo '<div>Bloc modifié avec succès !</div>';
        exit;
    } else {
        echo '<div>Erreur lors de la modification du bloc.</div>';
    }
    
    $bloc = fetchBlocById($bdd, $id);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Bloc</title>
    
</head>
<body>

    <h1>Modifier Bloc</h1>

    <?php if (isset($bloc)): ?>
    <form method="POST" action="">
        <input type="hidden" name="id_bloc" value="<?php echo htmlspecialchars($bloc['id_bloc']); ?>">
        
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($bloc['nom_bloc']); ?>" required>
        </div>
        
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($bloc['description']); ?></textarea>
        </div>
        
        <div>
            <button type="submit" name="modifier">Modifier</button>
        </div>
    </form>
    <?php else: ?>
    <div>Aucun bloc sélectionné pour modification.</div>
    <?php endif; ?>

</body>
</html>
