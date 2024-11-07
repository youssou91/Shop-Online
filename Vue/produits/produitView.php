<!DOCTYPE html>
<html lang="fr">
<?php
    // $productController->ajoutProduit();
?>
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
                            <td class="py-3 px-4"><?= htmlspecialchars("??"); ?></td>
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
            <form method="POST" enctype="multipart/form-data" class="space-y-4" action="produitView.php">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label for="nom" class="block text-xs font-medium text-gray-700">Nom produit</label>
                        <input type="text" id="nom" name="nom" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                    </div>
                    <div>
                        <label for="prix" class="block text-xs font-medium text-gray-700">Prix unitaire</label>
                        <input type="number" id="prix" name="prix" step="0.01" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label for="quantite" class="block text-xs font-medium text-gray-700">Quantité</label>
                        <input type="number" id="quantite" name="quantite" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                    </div>
                    <div>
                        <label for="id_categorie" class="block text-xs font-medium text-gray-700">Catégorie</label>
                        <!-- <select id="id_categorie" name="id_categorie" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                            <option selected value="">Choisir une catégorie</option>
                        </select> -->
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label for="taille_produit" class="block text-xs font-medium text-gray-700">Model</label>
                        <!-- <select id="taille_produit" name="taille_produit" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                            <option selected value="">Choisir un model</option>
                        </select> -->
                    </div>
                    <div>
                        <label for="image" class="block text-xs font-medium text-gray-700">Image</label>
                        <input type="file" id="image" name="image" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                </div>

                <!-- Quatrième ligne : Courte description et Longue description -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label for="courteDescription" class="block text-xs font-medium text-gray-700">Courte description</label>
                        <input type="text" id="courteDescription" name="courteDescription" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" required>
                    </div>
                    <div>
                        <label for="longueDescription" class="block text-xs font-medium text-gray-700">Longue Description</label>
                        <textarea id="longueDescription" name="longueDescription" class="w-full mt-1 p-2 border border-gray-300 rounded-lg text-sm" rows="2" required></textarea>
                    </div>
                </div>

                <!-- Couleurs disponibles -->
                <div>
                    <label class="block text-xs font-medium text-gray-700">Couleurs disponibles</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <div>
                            <input type="checkbox" id="rouge" name="couleurs[]" value="Rouge" class="focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <label for="rouge" class="ml-1 text-sm">Rouge</label>
                        </div>
                        <div>
                            <input type="checkbox" id="bleu" name="couleurs[]" value="Bleu" class="focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <label for="bleu" class="ml-1 text-sm">Bleu</label>
                        </div>
                        <div>
                            <input type="checkbox" id="vert" name="couleurs[]" value="Vert" class="focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <label for="vert" class="ml-1 text-sm">Vert</label>
                        </div>
                        <div>
                            <input type="checkbox" id="noir" name="couleurs[]" value="Noir" class="focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <label for="noir" class="ml-1 text-sm">Noir</label>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
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

    <!-- Initialisation de DataTable -->
    <script>
        $(document).ready(function() {
            $('#produitTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/French.json"
                }
            });
        });

        // Fonctions pour ouvrir et fermer le modal
        function openModal() {
            document.getElementById("productModal").classList.remove("hidden");
        }

        function closeModal() {
            document.getElementById("productModal").classList.add("hidden");
        }
    </script>
</body>

</html>
