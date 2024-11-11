<?php
// ProduitController.php
include '../Model/ProduitModel.php';
include '../Model/CategorieModel.php';

class ProduitController {
    private $produitModel;
    private $categorieModel;

    public function __construct($produitModel, $categorieModel) {
        $this->produitModel = $produitModel;
        $this->categorieModel = $categorieModel;
    }

    // Méthode pour afficher tous les produits
    public function afficherProduits() {
        return $this->produitModel->getAllProduits();
    }

    // Méthode pour afficher toutes les catégories
    public function afficherCategories() {
        return $this->categorieModel->getAllCategories();
    }
    //methode pour ajouter les produits
    public function ajouterProduit($produit) {
        // Récupération de l'image via $_FILES
        $data = [
            'image' => $_FILES['image']  // Ajouter l'image provenant de l'upload
        ];
    
        // Ajout du produit
        $resultat = $this->produitModel->ajoutProduit($produit, $data);
    
        if ($resultat) {
            echo "Produit ajouté avec succès !";
        } else {
            echo "Échec de l'ajout du produit.";
        }
    }
    
}

$serverName = "localhost";
$username = "root";
$password = "";

try {
    $connexion = new PDO("mysql:host=$serverName; dbname=cours343", $username, $password);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Gestion des erreurs
    
    // Instanciation des modèles avec la connexion PDO
    $modelP = new ProduitModel($connexion);
    $modelC = new CategorieModel($connexion);  // Correction : Utilisation de CategorieModel pour $modelC
    
    // Instanciation du contrôleur avec les modèles
    $controller = new ProduitController($modelP, $modelC);

    // Appel de la méthode pour afficher les produits et catégories, transmis à la vue
    $produits = $controller->afficherProduits();
    $categories = $controller->afficherCategories();
    
    include '../vue/produits/produitView.php';
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}
