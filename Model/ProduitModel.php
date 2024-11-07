<?php
include '../Classes/Produit.php';

class ProduitModel {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function getAllProduits() {
        $sql = "SELECT p.*, i.chemin_image FROM produits p LEFT JOIN image i ON p.id_produit = i.id_produit";
        try {
            $query = $this->conn->prepare($sql);
            $query->execute();
            $produits = [];  // Initialise un tableau vide pour stocker les produits
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $produits[] = new Produit(
                    $row['nom'], 
                    $row['prix_unitaire'], 
                    $row['description'], 
                    $row['courte_description'], 
                    $row['quantite'], 
                    $row['id_categorie'], 
                    explode(", ", $row['couleurs_prod'])  // Transforme la chaîne de couleurs en tableau
                );
            }
            return $produits;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function ajoutProduit($produit, $data) {
        try {
            // Requête d'insertion dans la table "produits"
            $sql = "INSERT INTO produits (nom, prix_unitaire, description, courte_description, quantite, id_categorie, couleurs_prod) 
                    VALUES (:nom, :prix, :description, :courte_description, :quantite, :id_categorie, :couleurs_prod)";
            
            $query = $this->conn->prepare($sql);
            $couleurs_prod = implode(", ", $produit['couleurs_prod']);

            $resultat = $query->execute([
                ':nom' => $produit['nom'],
                ':prix' => $produit['prix_unitaire'],
                ':description' => $produit['description'],
                ':courte_description' => $produit['courte_description'],
                ':quantite' => $produit['quantite'],
                ':id_categorie' => $produit['id_categorie'],
                ':couleurs_prod' => $couleurs_prod,
            ]);

            if ($resultat) {
                $id_produit = $this->conn->lastInsertId();
                return $this->uploadImage($data, $id_produit);
            }
            return false;

        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

    private function uploadImage($data, $id_produit) {
        if (isset($data['image']) && $data['image']['error'] === UPLOAD_ERR_OK) {
            $image_name = $data['image']['name'];
            $image_destination = 'images/' . basename($image_name);
            $from = $data['image']['tmp_name'];
            $image_type = strtolower(pathinfo($image_destination, PATHINFO_EXTENSION));

            if (in_array($image_type, ['jpg', 'jpeg', 'png', 'gif'])) {
                if (move_uploaded_file($from, $image_destination)) {
                    return $this->ajoutImage(['chemin_image' => $image_destination, 'id_produit' => $id_produit]);
                }
            }
        }
        return false;
    }

    private function ajoutImage($image) {
        $sql = "INSERT INTO image (chemin_image, id_produit) VALUES (:chemin_image, :id_produit)";
        $query = $this->conn->prepare($sql);
        return $query->execute([
            ':chemin_image' => $image['chemin_image'],
            ':id_produit' => $image['id_produit']
        ]);
    }
}

    // public function updateProduit($produit) {
    //     $sql = "UPDATE produits SET nom = :nom, prix_unitaire = :prix_unitaire, description = :description, courte_description = :courte_description, quantite = :quantite WHERE id_produit = :id";
    //     $query = $this->conn->prepare($sql);
    //     $query->bindParam(':nom', $produit['nom']);
    //     $query->bindParam(':prix_unitaire', $produit['prix_unitaire']);
    //     $query->bindParam(':description', $produit['description']);
    //     $query->bindParam(':courte_description', $produit['courte_description']);
    //     $query->bindParam(':quantite', $produit['quantite']);
    //     $query->bindParam(':id', $produit['id_produit']);
    //     return $query->execute();
    // }

    // public function deleteProduit($idProduit) {
    //     $this->deleteProduitPromotion($idProduit);
    //     $this->deleteProduitImages($idProduit);
        
    //     $sql = "DELETE FROM produits WHERE id_produit = :id";
    //     $query = $this->conn->prepare($sql);
    //     $query->bindParam(':id', $idProduit);
    //     return $query->execute();
    // }

    // private function deleteProduitPromotion($idProduit) {
    //     $sql = "DELETE FROM produitpromotion WHERE id_produit = :id";
    //     $query = $this->conn->prepare($sql);
    //     $query->bindParam(':id', $idProduit);
    //     return $query->execute();
    // }

    // private function deleteProduitImages($idProduit) {
    //     $sql = "DELETE FROM image WHERE id_produit = :id";
    //     $query = $this->conn->prepare($sql);
    //     $query->bindParam(':id', $idProduit);
    //     return $query->execute();
    // }

