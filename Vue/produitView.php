<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Boutique - Liste des Produits</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    
    <!-- jQuery et DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body class="bg-gray-100 py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-center mb-10">Liste des Produits</h1>
        
        <table id="produitTable" class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Nom</th>
                    <th class="py-3 px-4 text-left">Prix</th>
                    <th class="py-3 px-4 text-left">Description</th>
                    <th class="py-3 px-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Boucle pour afficher chaque produit
                $count = 1;
                foreach ($produit as $prod) { ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-4"><?= $count++; ?></td>
                        <td class="py-3 px-4"><?= htmlspecialchars($prod->getNom()); ?></td>
                        <td class="py-3 px-4">
                            <?= is_numeric($prod->getPrixUnitaire()) ? number_format($prod->getPrixUnitaire(), 2) . ' $' : 'N/A'; ?>
                        </td>
                        <td class="py-3 px-4"><?= htmlspecialchars($prod->getDescription()); ?></td>
                        <td class="py-3 px-4">
                            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Voir</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Initialisation de DataTable -->
    <script>
        $(document).ready(function() {
            $('#produitTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/French.json"
                }
            });
        });
    </script>
</body>

</html>
