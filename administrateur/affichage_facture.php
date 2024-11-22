<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>affichage_facture</title>
<style>
table {
    border-collapse: collapse;
    width: 70%; /* Réduit la largeur du tableau */
    max-width: 800px; /* Limite la largeur maximale */
    margin: 20px auto; /* Centre le tableau avec une marge */
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    padding:20px;
    height: 200vh;
}

th, td {
    padding: 10px 15px; /* Réduit l'espacement pour compacter le tableau */
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #f1f1f1;
}

td a {
    color: #007BFF;
    text-decoration: none;
    padding: 6px 10px; /* Réduit la taille des boutons */
    border-radius: 5px;
    transition: background-color 0.3s ease;
    display: inline-block;
}

td a.btn-modifier {
    background-color: #FFA500;
    color: white;
}

td a.btn-supprimer {
    background-color: #FF6347;
    color: white;
}

td a:hover {
    background-color: #007BFF;
    color: white;
}
  
</style>
</head>
<body>
<?php
include "Accueil.php";
include "connexion.php";
?>


<?php include 'Accueil.php';?>;
    <div class="container">
        <h1>Liste des factures</h1>

        <?php
        // Create the PDO connection first
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=chambre_lit;charset=utf8', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }

        // Check if a delete request has been made
        if (isset($_GET["sup"])) {
            $id_fact = (int)$_GET['sup']; // Cast to int for safety
            try {
                $suppression = $pdo->prepare("DELETE FROM facture WHERE id_facture = :id_facture");
                $suppression->execute([':id_facture' => $id_fact]);
                echo '<div class="message success">ce facture supprimé avec succès.</div>';
            } catch (PDOException $e) {
                echo '<div class="message error">Erreur lors de la suppression : ' . $e->getMessage() . '</div>';
            }
        }

        // Fetch all records from the bloc table
        $affichagebloc = $pdo->query("SELECT * FROM facture");
        ?>
         <table>
            <thead>
                <tr>
                    <th>type_facture</th>
                    <th>date_paye</th>
                    <th>nom</th>
                    <th>prenom</th>
                    <th>motif</th>
                    <th colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($ContactRecup = $affichagebloc->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ContactRecup["type_facture"]); ?></td>
                        <td><?php echo htmlspecialchars($ContactRecup["date_paye"]); ?></td>
                        <td><?php echo htmlspecialchars($ContactRecup["nom"]);?></td>
                        <td><?php echo htmlspecialchars($ContactRecup["prenom"]);?></td>
                        <td><?php echo htmlspecialchars($ContactRecup["motif"]);?></td>
                        <td>
                            <a href="Modifiefacture.php?id=<?php echo $ContactRecup["id_facture"]; ?>" class="btn btn-primary">Modifier</a>
                            <a href="affichage_facture.php?sup=<?php echo $ContactRecup["id_facture"]; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce facture ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
</table>
</body>
</html>
