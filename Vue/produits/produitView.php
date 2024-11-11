<?php
require_once '../config.php';
require_once '../Controlleur/ProduitController.php';
require_once '../Model/ProduitModel.php';  // Assurez-vous d'inclure ProduitModel
require_once '../Model/CategorieModel.php'; // Assurez-vous d'inclure CategorieModel

// Connexion à la base de données
$dbConnection = getConnection();

// Instanciation des modèles
$produitModel = new ProduitModel($dbConnection);
$categorieModel = new CategorieModel($dbConnection);

// Instanciation du contrôleur avec les deux modèles
$produitController = new ProduitController($produitModel, $categorieModel);

// Récupération des produits et catégories
$produits = $produitController->afficherProduits();
$categories = $produitController->afficherCategories();


$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation des couleurs
    $couleurs = isset($_POST['couleurs']) ? implode(',', $_POST['couleurs']) : '';

    // Vérification de l'image
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['image']['name']; // Nom original du fichier
        $tmpFilePath = $_FILES['image']['tmp_name']; // Chemin temporaire du fichier
    } else {
        $filename = null;
        $tmpFilePath = null;
    }

    // Assurez-vous que le dossier 'images' existe
    $targetDir = '../images/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Crée le dossier avec des permissions si inexistant
    }

    if ($filename && $tmpFilePath) {
        $targetFile = $targetDir . basename($filename); // Nom complet du fichier

        // Essayez de déplacer le fichier
        if (move_uploaded_file($tmpFilePath, $targetFile)) {
            $imagePath = $targetFile;
        } else {
            echo "Erreur : Échec du déplacement de l'image.";
            return false;
        }
    }

    // Définition des données du produit
    $produit = [
        'nom' => $_POST['nom'] ?? '',
        'prix_unitaire' => $_POST['prix_unitaire'] ?? 0,
        'description' => $_POST['description'] ?? '',
        'courte_description' => $_POST['courte_description'] ?? '',
        'quantite' => $_POST['quantite'] ?? 0,
        'id_categorie' => $_POST['id_categorie'] ?? null,
        'model' => $_POST['model'] ?? '',
        'couleurs_prod' => isset($_POST['couleurs']) ? $_POST['couleurs'] : [] // Validation de couleurs
    ];

    // Appel du contrôleur pour ajouter le produit
    $result = $produitController->ajouterProduit($produit);

    
}
?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ma Boutique - Liste des Produits</title>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <!-- Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <!-- jQuery et DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    </head>

    <body class="bg-gray-100 py-10">
        <div class="container mx-auto px-10">
            <h1 class="text-3xl font-bold text-center mb-10">Liste des Produits</h1>
            
            <!-- Bouton pour ajouter un produit -->
            <div class="text-right mb-4">
                <button onclick="openModal()" class="bg-green-500 text-white font-bold py-2 px-4 rounded shadow hover:bg-green-600 transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Ajouter un produit
                </button>
            </div>

            <!-- Tableau des produits -->
            <table id="produitTable" class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">#</th>
                        <th class="py-3 px-4 text-left">Image</th>
                        <th class="py-3 px-4 text-left">Nom</th>
                        <th class="py-3 px-4 text-left">Prix</th>
                        <th class="py-3 px-4 text-left">Quantite</th>
                        <th class="py-3 px-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($produits) && !empty($produits)) {
                        $count = 1;
                        foreach ($produits as $prod) { ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4"><?= $count++; ?></td>
                                <td>
                                        <img style='width: 50px; height: 50px; border-radius:50%;' src="<?php
                                        echo (isset($produit['chemin_image']) && !empty($produit['chemin_image'])) ?
                                        $produit['chemin_image'] : "images/Image 001.jpeg"; ?>">
                                
                                </td>                         
                                <td class="py-3 px-4"><?= htmlspecialchars($prod->getNom()); ?></td>
                                <td class="py-3 px-4"><?= is_numeric($prod->getPrixUnitaire()) ? number_format($prod->getPrixUnitaire(), 2) . ' $' : 'N/A'; ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars($prod->getQuantite()); ?></td>
                                <td class="py-3 px-4 flex space-x-2">
                                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"><i class="fas fa-eye"></i></button>
                                    <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600"><i class="fas fa-edit"></i></button>
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr><td colspan="6" class="py-3 px-4 text-center">Aucun produit trouvé</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div id="productModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex justify-center items-center transition-opacity duration-300 ease-in-out">
            <div class="bg-white p-6 rounded-lg max-w-xl w-full shadow-lg transform transition-all duration-500 ease-in-out">
                <h2 class="text-xl font-bold text-center text-gray-800 mb-4">Ajouter un produit</h2>
                <form method="POST" enctype="multipart/form-data" class="space-y-4">
                    <!-- Champs de base pour le produit -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <label for="nom" class="block text-xs font-medium text-gray-700">Nom produit</label>
                            <input type="text" id="nom" name="nom" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label for="prix" class="block text-xs font-medium text-gray-700">Prix unitaire</label>
                            <input type="number" id="prix" name="prix_unitaire" step="0.01" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <label for="quantite" class="block text-xs font-medium text-gray-700">Quantité</label>
                            <input type="number" id="quantite" name="quantite" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label for="id_categorie" class="block text-xs font-medium text-gray-700">Catégorie</label>
                            <select id="id_categorie" name="id_categorie" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                                <option selected value="">Choisir une catégorie</option>
                                <?php
                                foreach ($categories as $categorie) {
                                    echo "<option value='" . $categorie->getId_categorie() . "'>" . htmlspecialchars($categorie->getNom_categorie()) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Champs supplémentaires -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <label for="model" class="block text-xs font-medium text-gray-700">Model</label>
                            <input type="text" id="model" name="model" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label for="image" class="block text-xs font-medium text-gray-700">Image</label>
                            <input type="file" id="image" name="image" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div>
                            <label for="courteDescription" class="block text-xs font-medium text-gray-700">Courte description</label>
                            <input type="text" id="courteDescription" name="courte_description" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                        </div>
                        <div>
                            <label for="longueDescription" class="block text-xs font-medium text-gray-700">Longue Description</label>
                            <textarea id="longueDescription" name="description" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" rows="2" required></textarea>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Couleurs disponibles</label>
                        <label for="couleurs">Couleurs :</label>
                        <input type="checkbox" name="couleurs_prod[]" value="Rouge"> Rouge
                        <input type="checkbox" name="couleurs_prod[]" value="Bleu"> Bleu
                        <input type="checkbox" name="couleurs_prod[]" value="Vert"> Vert
                        <input type="checkbox" name="couleurs_prod[]" value="Noir"> Noir
                        <input type="checkbox" name="couleurs_prod[]" value="Blanc"> Blanc
                        <input type="checkbox" name="couleurs_prod[]" value="Gris"> Gris
                        <input type="checkbox" name="couleurs_prod[]" value="Jaune"> Jaune
                        <input type="checkbox" name="couleurs_prod[]" value="Rose"> Rose
                        <input type="checkbox" name="couleurs_prod[]" value="Marron"> Marron

                        
                    </div>

                    <div class="flex justify-end space-x-2 mt-3">
                        <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600 text-sm transition duration-150 ease-in-out">Annuler</button>
                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm transition duration-150 ease-in-out">Enregistrer</button>
                    </div>
                </form>

            </div>
        </div>


    <script>
        function openModal() {
            document.getElementById('productModal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('productModal').classList.add('hidden');
        }
    </script>

        <script>
            $(document).ready(function() {
                $('#produitTable').DataTable({
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/French.json"
                    }
                });
            });

            function openModal() {
                document.getElementById("productModal").classList.remove("hidden");
            }

            function closeModal() {
                document.getElementById("productModal").classList.add("hidden");
            }
        </script>
    </body>
</html>
