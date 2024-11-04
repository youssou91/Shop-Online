<?php
include '../Model/ProduitModel.php';

class ProduitController {
    private $produitModel;
    public function __construct($produitModel) {
        $this->produitModel = $produitModel;
    }
 
    public function getProduits() {
        return $this->produitModel->getAllProduits();
    }

    // public function getProduitById($id) {
    //     return $this->produitModel->getProduitById($id);
    // }

    // public function ajoutProduit($produit, $data) {
    //     if ($this->produitModel->ajoutProduit($produit, $data)) {
    //         echo "Produit ajouté avec succès.";
    //     } else {
    //         echo "Erreur lors de l'ajout du produit.";
    //     }
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
}

    $serverName = "localhost";
    $username = "root";
    $password = "";
    try{
        $connexion = new PDO("mysql:host=$serverName; dbname=cours343", $username, $password);
        $model = new ProduitModel($connexion);
        $controlleur = new ProduitController($model);
        $produit = $controlleur->getProduits();
        include '../vue/produitView.php';
    }catch(Exception $e){
        echo "Connection failed: ". $e->getMessage();
    }


?>