<?php
session_start();
include 'controlleur.php'; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>YAHLI-SHOP</title>
        
        <!-- Lien vers Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Bootstrap Icons et Boxicons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-50">

        <!-- Header avec la Navbar -->
        <header class="bg-white shadow-md">
            <nav class="flex items-center justify-between px-6 py-4">
                <a class="text-2xl font-bold text-blue-600 hover:text-blue-800 transition duration-300" href="index.php">YAHLI-SHOP</a>
                
                <div class="flex items-center space-x-6">
                    <a href="index.php" class="text-lg text-gray-700 hover:text-blue-500 transition duration-300">Accueil</a>
                    <a href="contact.php" class="text-lg text-gray-700 hover:text-blue-500 transition duration-300">Contact</a>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="commandesAdmin.php" class="text-lg text-gray-700 hover:text-blue-500 transition duration-300">Commandes</a>
                        <a href="produits.php" class="text-lg text-gray-700 hover:text-blue-500 transition duration-300">Produits</a>
                        <a href="utilisateurs.php" class="text-lg text-gray-700 hover:text-blue-500 transition duration-300">Utilisateurs</a>
                        <a href="admin_promotions.php" class="text-lg text-gray-700 hover:text-blue-500 transition duration-300">Promo</a>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['id_utilisateur'])): ?>
                        <a href="profile.php" class="text-lg text-gray-700 hover:text-blue-500 transition duration-300">Mon Profil</a>
                        <a href="deconnexion.php" class="text-lg text-red-600 hover:text-red-800 transition duration-300">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </a>
                    <?php else: ?>
                        <a href="connexion.php" class="text-lg text-blue-600 hover:text-blue-800 transition duration-300">
                            <i class="bi bi-box-arrow-in-right"></i> Connexion
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        </header>

        <!-- Carrousel d'images -->
        <div id="carouselExampleCaptions" class="carousel slide relative" data-bs-ride="carousel">
            <ol class="carousel-indicators absolute top-0 right-0 left-0 z-10 flex justify-center space-x-3">
                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active bg-white rounded-full w-2.5 h-2.5"></li>
                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" class="bg-white rounded-full w-2.5 h-2.5"></li>
                <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" class="bg-white rounded-full w-2.5 h-2.5"></li>
            </ol>
            <div class="carousel-inner relative w-full overflow-hidden">
                <div class="carousel-item active">
                    <img src="./images/color.jpg" class="d-block w-full h-96 object-cover" alt="Image 1">
                </div>
                <div class="carousel-item">
                    <img src="./images/Media.jpg" class="d-block w-full h-96 object-cover" alt="Image 2">
                </div>
                <div class="carousel-item">
                    <img src="./images/black.jpg" class="d-block w-full h-96 object-cover" alt="Image 3">
                </div>  
            </div>
        </div>

        <script src="js/script.js"></script>
    </body>
</html>
