<?php
// Start session if it’s not started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set language from URL or default to 'en'
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Ensure language is set in session, default to 'en' if not
$lang = $_SESSION['lang'] ?? 'en';
isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

// Validate and include the corresponding language file
$languageFile = __DIR__ . "/lang/{$lang}.php";
if (file_exists($languageFile)) {
    include_once $languageFile;
} else {
    include_once __DIR__ . "/lang/en.php"; // Fallback to English
}

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', '1'); // Set to '0' in production
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/logs/error.log');

// Get the controller and action from URL parameters
$controller = isset($_GET['controller']) ? ucfirst($_GET['controller']) : "User";
$action = isset($_GET['action']) ? $_GET['action'] : "login";
$controllerClassName = $controller . "Controller";
$controllerFile = __DIR__ . "/Controllers/$controllerClassName.php";

try {
    if (file_exists($controllerFile)) {
        include_once $controllerFile;
        if (class_exists($controllerClassName)) {
            $ct = new $controllerClassName();
            $ct->route($action);
        } else {
            throw new Exception("Controller class '$controllerClassName' not found.");
        }
    } else {
        throw new Exception("Controller file '$controllerFile' not found.");
    }
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo "<h1>500 Internal Server Error</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}


?>
