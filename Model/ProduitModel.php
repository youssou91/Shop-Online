<?php
class ProduitModel {
    private $conn;

    public function __construct() {
        $this->conn = $this->connexionDB();
    }

    private function connexionDB() {
        $host = 'localhost';
        $dbname = 'votre_base_de_donnees';
        $username = 'votre_utilisateur';
        $password = 'votre_mot_de_passe';

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
            return null;
        }
    }

    public function ajoutProduit($produit, $data) {
        $sql = "INSERT INTO produits (nom, prix_unitaire, description, courte_description, quantite, id_categorie, taille_produit, sexe_prod, couleurs_prod) VALUES (:nom, :prix, :description, :courte_description, :quantite, :id_categorie, :taille_produit, :sexe_prod, :couleurs_prod)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nom', $produit['nom_prod']);
        $stmt->bindParam(':prix', $produit['prix_prod']);
        $stmt->bindParam(':description', $produit['longueDescription_prod']);
        $stmt->bindParam(':courte_description', $produit['courteDescription_prod']);
        $stmt->bindParam(':quantite', $produit['quantite_prod']);
        $stmt->bindParam(':id_categorie', $produit['id_categorie']);
        $stmt->bindParam(':taille_produit', $produit['taille_produit']);
        $stmt->bindParam(':sexe_prod', $produit['sexe_prod']);
        $couleurs_prod = implode(", ", $produit['couleurs_prod']);
        $stmt->bindParam(':couleurs_prod', $couleurs_prod);

        $resultat = $stmt->execute();

        if ($resultat) {
            $id_produit = $this->conn->lastInsertId();
            return $this->uploadImage($data, $id_produit);
        }
        return false;
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
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':chemin_image', $image['chemin_image']);
        $stmt->bindParam(':id_produit', $image['id_produit']);
        return $stmt->execute();
    }

    public function getProduits() {
        $sql = "SELECT p.*, i.chemin_image FROM produits p LEFT JOIN image i ON p.id_produit = i.id_produit";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduitById($id) {
        $sql = "SELECT * FROM produits WHERE id_produit = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduit($produit) {
        $sql = "UPDATE produits SET nom = :nom, prix_unitaire = :prix_unitaire, description = :description, courte_description = :courte_description, quantite = :quantite WHERE id_produit = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nom', $produit['nom']);
        $stmt->bindParam(':prix_unitaire', $produit['prix_unitaire']);
        $stmt->bindParam(':description', $produit['description']);
        $stmt->bindParam(':courte_description', $produit['courte_description']);
        $stmt->bindParam(':quantite', $produit['quantite']);
        $stmt->bindParam(':id', $produit['id_produit']);
        return $stmt->execute();
    }

    public function deleteProduit($idProduit) {
        $this->deleteProduitPromotion($idProduit);
        $this->deleteProduitImages($idProduit);
        
        $sql = "DELETE FROM produits WHERE id_produit = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $idProduit);
        return $stmt->execute();
    }

    private function deleteProduitPromotion($idProduit) {
        $sql = "DELETE FROM produitpromotion WHERE id_produit = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $idProduit);
        return $stmt->execute();
    }

    private function deleteProduitImages($idProduit) {
        $sql = "DELETE FROM image WHERE id_produit = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $idProduit);
        return $stmt->execute();
    }
}
