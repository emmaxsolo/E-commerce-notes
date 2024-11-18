<?php
include_once "Models/User.php";
include_once "Controllers/Controller.php";
class UserController extends Controller {
    function route() {
        $lang = $_SESSION['lang'] ?? 'en'; // Default to 'en' if language is not set
        $action = isset($_GET['action']) ? $_GET['action'] : "login"; // Default to login
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        switch ($action) {
            case "create":
                $this->render("Event", "createEventForm", ['lang' => $lang]);
                break;
            case "loginProcess":
                $this->loginUser();
                break;
            case "register":
                $this->render("User", "register", ['lang' => $lang]);
                break;
            case "registerSave":
                $this->registerUser();
                break;
            case "logout":
                $this->logoutUser();
                break;
            case "dashboard":
                $this->dashboard();
                break;
            default:
            $this->render("User", "login", ['lang' => $lang]);
            break;
        }
    }

    private function loginUser() {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        if (!$username || !$password) {
            echo "Username and password are required.";
            return;
        }
    
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Start session if not already started
        }
    
        $user = new User();
        $userData = $user->login($username, $password);
    
        if ($userData) {
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['is_admin'] = $userData['isAdmin'];
    
            $lang = $_SESSION['lang'] ?? 'en'; // Set language based on session
            header("Location: /PracticeProject/{$lang}/user/dashboard"); // Include language in the redirect
            exit;
        } else {
            echo "Invalid username or password.";
        }
    }
    

    private function registerUser() {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $isAdmin = isset($_POST['isAdmin']) && $_POST['isAdmin'] === '1';

        if (!$username || !$password) {
            echo "Username and password are required.";
            return;
        }

        $user = new User();
        if ($user->register($username, $password, $isAdmin)) {
            $lang = $_SESSION['lang'] ?? 'en';
            header("Location: /PracticeProject/{$lang}/login");
                        exit;
        } else {
            echo "Error registering user.";
        }
    }

    private function logoutUser() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
    
        $lang = $_SESSION['lang'] ?? 'en'; // Set language based on session
        header("Location: /PracticeProject/{$lang}/user/login"); // Include language in the redirect
        exit;
    }
    
    
    private function dashboard() {
        if (!isset($_SESSION['user_id'])) {
            $lang = $_SESSION['lang'] ?? 'en'; // Set language based on session
            header("Location: /PracticeProject/{$lang}/user/login"); // Include language in the redirect
            exit;
        }
    
        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
        $this->render("User", "dashboard", ['isAdmin' => $isAdmin]);
    }
    
}
?>