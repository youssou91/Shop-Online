<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du produit</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($produit['nom']); ?></h1>
    <p>Prix : <?php echo htmlspecialchars($produit['prix_unitaire']); ?> €</p>
    <p>Description : <?php echo htmlspecialchars($produit['description']); ?></p>
</body>
</html>
