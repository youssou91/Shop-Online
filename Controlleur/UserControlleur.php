<?php

// require_once './Model/UserModel.php';
require_once __DIR__ . '/../Model/UserModel.php';


class UserController {
    private $userModel;

    // Constructor to initialize the UserModel
    public function __construct($dbConnection) {
        $this->userModel = new UserModel($dbConnection);
    }

    // Méthode pour enregistrer un nouvel utilisateur
    public function registerUser($user) {
        try {
            // Valider les données de l'utilisateur
            $this->userModel->validateUserData(
                $user['couriel'], 
                $user['password'], 
                $user['cpassword'], 
                $user['datNaiss']
            );

            // Ajouter l'utilisateur dans la base de données
            $result = $this->userModel->addUserDB($user);

            if ($result === true) {
                // Renvoie un message de succès uniquement
                return ['success' => true, 'message' => 'L\'utilisateur a été ajouté avec succès !'];
            } else {
                // Retourne l'erreur si l'ajout échoue
                return ['success' => false, 'message' => $result];
            }
        } catch (Exception $e) {
            // Gérer les exceptions
            return ['success' => false, 'message' => 'Erreur : ' . $e->getMessage()];
        }
    }


    // Method to fetch all users
    public function getAllUsers() {
        $users = $this->userModel->getAllUsers();
        return $users;
    }

    // Method to get user information by user ID
    public function getUserInfo($id_utilisateur) {
        $userInfo = $this->userModel->getUserInfo($id_utilisateur);
        return $userInfo;
    }

    // Method to authenticate user (login)
    public function loginUser($email, $password) {
        $user = $this->userModel->checkUser($email, $password);
        
        if ($user) {
            // Store user session or token
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['role'] = $user['role'];
            return true;
        } else {
            return false;
        }
    }

    // Method to display the registration form (optional)
    public function showRegistrationForm() {
        include 'views/register.php'; // Assumes you have a view for registration
    }

    // Method to display user login form (optional)
    public function showLoginForm() {
        include 'views/login.php'; // Assumes you have a view for login
    }

    // Method to handle the logout (optional)
    public function logoutUser() {
        session_destroy();
        header('Location: index.php'); // Redirect to home page after logout
    }
}

?>
