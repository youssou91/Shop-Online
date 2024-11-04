<?php
require_once 'ProduitModel.php';

class ProduitController {
    private $produitModel;

    public function __construct() {
        $this->produitModel = new ProduitModel();
    }

    public function ajoutProduit($produit, $data) {
        if ($this->produitModel->ajoutProduit($produit, $data)) {
            echo "Produit ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du produit.";
        }
    }

    public function getProduits() {
        return $this->produitModel->getProduits();
    }

    public function getProduitById($id) {
        return $this->produitModel->getProduitById($id);
    }

    public function updateProduit($produit) {
        if ($this->produitModel->updateProduit($produit)) {
            echo "Produit mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du produit.";
        }
    }

    public function deleteProduit($idProduit) {
        if ($this->produitModel->deleteProduit($idProduit)) {
            echo "Produit supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du produit.";
        }
    }
}
