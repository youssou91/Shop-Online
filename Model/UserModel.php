<?php

class UserModel {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Function to add user to the DB
    public function addUserDB($user) {
        // Start a transaction
        $this->conn->beginTransaction();

        try {
            // Insert user, address, and associate them
            $id_utilisateur = $this->insertUser($user);
            $id_adresse = $this->insertAddress($user);
            $this->associateUserAddress($id_utilisateur, $id_adresse);
            $this->assignUserRole($id_utilisateur, 'client');

            // Commit the transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback if an error occurs
            $this->conn->rollBack();
            return "Error adding user: " . $e->getMessage();
        }
    }

    // Insert user into the user table
    private function insertUser($user) {
        // Prepare the user data
        $sql = "INSERT INTO utilisateur (nom_utilisateur, prenom, date_naissance, couriel, mot_de_pass, telephone, statut) 
                VALUES (:nom_utilisateur, :prenom, :datNaiss, :couriel, :password, :telephone, :statut)";
        
        $stmt = $this->conn->prepare($sql);
        
        // Hash the password
        $passwordHash = password_hash($user['password'], PASSWORD_DEFAULT);

        $stmt->execute([
            ':nom_utilisateur' => $user['nom_utilisateur'],
            ':prenom' => $user['prenom'],
            ':datNaiss' => $user['datNaiss'],
            ':couriel' => $user['couriel'],
            ':password' => $passwordHash,
            ':telephone' => $user['telephone'],
            ':statut' => 'actif'
        ]);

        return $this->conn->lastInsertId();
    }

    // Insert address into the address table
    private function insertAddress($user) {
        $sql = "INSERT INTO adresse (rue, ville, code_postal, pays, numero, province) 
                VALUES (:rue, :ville, :code_postal, :pays, :numero, :province)";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute([
            ':rue' => $user['rue'],
            ':ville' => $user['ville'],
            ':code_postal' => $user['code_postal'],
            ':pays' => $user['pays'],
            ':numero' => $user['numero'],
            ':province' => $user['province']
        ]);

        return $this->conn->lastInsertId();
    }

    // Associate user with address in the association table
    private function associateUserAddress($id_utilisateur, $id_adresse) {
        $sql = "INSERT INTO utilisateur_adresse (id_utilisateur, id_adresse) 
                VALUES (:id_utilisateur, :id_adresse)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id_utilisateur' => $id_utilisateur,
            ':id_adresse' => $id_adresse
        ]);
    }

    // Assign a role to the user
    private function assignUserRole($id_utilisateur, $role_description) {
        $role = $this->getRoleByDescription($role_description);

        $sql = "INSERT INTO role_utilisateur (id_role, id_utilisateur) 
                VALUES (:id_role, :id_utilisateur)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id_role' => $role['id_role'],
            ':id_utilisateur' => $id_utilisateur
        ]);
    }

    // Fetch role based on description
    private function getRoleByDescription($role_description) {
        $sql = "SELECT * FROM role WHERE description = :description";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':description' => $role_description]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Validate user data (Email, Password, etc.)
    public function validateUserData($email, $password, $cpassword, $birthDate) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email format is invalid.");
        }

        if ($this->getElementByEmailForAddUser($email)) {
            throw new Exception("Email already exists in the database.");
        }

        // Password validation
        if (strlen($password) < 6 || !preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[@$!%*?&]/', $password)) {
            throw new Exception("Password must contain at least 6 characters, one lowercase letter, one uppercase letter, one digit, and one special character.");
        }

        if ($password !== $cpassword) {
            throw new Exception("Passwords do not match.");
        }

        if ($this->calculateAge($birthDate) < 16) {
            throw new Exception("User must be at least 16 years old.");
        }
    }

    // Get user by email for registration validation
    private function getElementByEmailForAddUser($email) {
        $sql = "SELECT * FROM utilisateur WHERE couriel = :couriel";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':couriel' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Calculate age based on birthdate
    private function calculateAge($birthDate) {
        $birthDate = new DateTime($birthDate);
        $today = new DateTime();
        $age = $today->diff($birthDate);
        return $age->y;
    }
    
    // Fetch all users with their roles
    public function getAllUsers() {
        $sql = "SELECT u.*, r.description as role 
                FROM utilisateur u 
                JOIN role_utilisateur ru ON u.id_utilisateur = ru.id_utilisateur 
                JOIN role r ON ru.id_role = r.id_role";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get user information by ID
    public function getUserInfo($id_utilisateur) {
        $sql = "SELECT u.*, a.rue, a.numero, a.ville, a.code_postal, a.province, a.pays
                FROM utilisateur u
                LEFT JOIN utilisateur_adresse ua ON u.id_utilisateur = ua.id_utilisateur
                LEFT JOIN adresse a ON ua.id_adresse = a.id_adresse
                WHERE u.id_utilisateur = :id_utilisateur";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id_utilisateur' => $id_utilisateur]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Check user credentials for login
    public function checkUser($email, $password) {
        $user = $this->getElementByEmailForLogin($email);

        if ($user && password_verify($password, $user['mot_de_pass'])) {
            return $user;
        } else {
            return null;
        }
    }

    // Get user by email for login validation
    private function getElementByEmailForLogin($email) {
        $sql = "SELECT u.*, r.description as role
                FROM utilisateur u
                JOIN role_utilisateur ru ON u.id_utilisateur = ru.id_utilisateur
                JOIN role r ON ru.id_role = r.id_role
                WHERE u.couriel = :couriel";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':couriel' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
   
}

?>
