<?php
include '../Model/ProduitModel.php';

class ProduitController {
    private $produitModel;

    public function __construct($produitModel) {
        $this->produitModel = $produitModel;
    }

    public function ajoutProduit() {
        // Vérification que le formulaire est soumis en POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Traitement des données du formulaire
            $data = [
                'nom' => $_POST['nom'],
                'prix' => $_POST['prix'],
                'quantite' => $_POST['quantite'],
                'id_categorie' => $_POST['id_categorie'],
                // 'taille_produit' => $_POST['taille_produit'],
                'image' => $this->uploadImage(),
                'courteDescription' => $_POST['courteDescription'],
                'longueDescription' => $_POST['longueDescription'],
                'couleurs' => $_POST['couleurs'] ?? []
            ];
            // Appel du modèle pour insérer le produit
            if ($this->model->insertProduct($data)) {
                echo "Produit ajouté avec succès !";
            } else {
                echo "Erreur lors de l'ajout du produit.";
            }
        }
    
    }

    public function getProduits() {
        return $this->produitModel->getAllProduits();
    }
}

// Connexion et affichage des produits
$serverName = "localhost";
$username = "root";
$password = "";

try {
    $connexion = new PDO("mysql:host=$serverName; dbname=cours343", $username, $password);
    $model = new ProduitModel($connexion);
    $controlleur = new ProduitController($model);
    $produits = $controlleur->getProduits();
    include '../vue/produits/produitView.php';
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage();
}

// public function getProduitById($id) {
    //     return $this->produitModel->getProduitById($id);
    // }

    

    // public function updateProduit($produit) {
    //     if ($this->produitModel->updateProduit($produit)) {
    //         echo "Produit mis à jour avec succès.";
    //     } else {
    //         echo "Erreur lors de la mise à jour du produit.";
    //     }
    // }

    // public function deleteProduit($idProduit) {
    //     if ($this->produitModel->deleteProduit($idProduit)) {
    //         echo "Produit supprimé avec succès.";
    //     } else {
    //         echo "Erreur lors de la suppression du produit.";
    //     }
    // }
?>