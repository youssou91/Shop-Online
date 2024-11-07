<html>
<head>
    <title>Ajout de Produit</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 min-h-screen flex items-center justify-center p-4">
    <form method="POST" enctype="multipart/form-data" class="space-y-6 bg-white bg-opacity-90 p-8 rounded-2xl shadow-xl max-w-lg mx-auto">
        <h2 class="text-2xl font-bold text-center text-gray-800">Ajouter un produit</h2>

        <div>
            <label for="nom" class="block text-sm font-medium text-gray-700">Nom produit</label>
            <input type="text" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition" id="nom" name="nom_prod" placeholder="Nom produit" required>
        </div>
        
        <div>
            <label for="prix" class="block text-sm font-medium text-gray-700">Prix unitaire</label>
            <input type="number" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition" id="prix" name="prix_prod" placeholder="Prix unitaire" required>
        </div>

        <div>
            <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
            <input type="number" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition" id="quantite" name="quantite_prod" placeholder="Quantité produit" required>
        </div>

        <div>
            <label for="id_categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
            <select name="id_categorie" id="id_categorie" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition" required>
                <option selected value="">Choisir une catégorie</option>
                <!-- Remplacez par les options dynamiques PHP -->

            </select>
        </div>

        <div>
            <label for="taille_produit" class="block text-sm font-medium text-gray-700">Model</label>
            <select name="taille_produit" id="taille_produit" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition" required>
                <option selected value="">Choisir une model</option>
                <option value="Small">*****</option>
                <option value="Medium">*******</option>
                
            </select>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition" id="image" name="image">
        </div>

        <div>
            <label for="courteDescription" class="block text-sm font-medium text-gray-700">Courte description</label>
            <input type="text" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition" id="courteDescription" name="courteDescription_prod" placeholder="Courte description" required>
        </div>

        <div>
            <label for="longueDescription" class="block text-sm font-medium text-gray-700">Longue Description</label>
            <textarea class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none transition" id="longueDescription" name="longueDescription_prod" placeholder="Longue Description" required></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Sexe</label>
            <div class="flex space-x-4 mt-2">
                <div>
                    <input type="radio" id="homme" name="sexe_prod" value="Homme" required>
                    <label for="homme" class="ml-2 text-gray-700">Homme</label>
                </div>
                <div>
                    <input type="radio" id="femme" name="sexe_prod" value="Femme" required>
                    <label for="femme" class="ml-2 text-gray-700">Femme</label>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Couleurs disponibles</label>
            <div class="flex flex-wrap gap-4 mt-2">
                <div>
                    <input type="checkbox" id="rouge" name="couleurs_prod[]" value="Rouge">
                    <label for="rouge" class="ml-2 text-gray-700">Rouge</label>
                </div>
                <div>
                    <input type="checkbox" id="bleu" name="couleurs_prod[]" value="Bleu">
                    <label for="bleu" class="ml-2 text-gray-700">Bleu</label>
                </div>
                <div>
                    <input type="checkbox" id="vert" name="couleurs_prod[]" value="Vert">
                    <label for="vert" class="ml-2 text-gray-700">Vert</label>
                </div>
                <div>
                    <input type="checkbox" id="noir" name="couleurs_prod[]" value="Noir">
                    <label for="noir" class="ml-2 text-gray-700">Noir</label>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md transition transform hover:scale-105" name="btnAjout">
            Ajouter Produit
        </button>
    </form>
</body>
</html>
