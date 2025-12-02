<?php
/**
 * CEMAC Trading - Modern MVC Application
 * Main entry point for the application
 */

// Start session
session_start();

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('Africa/Douala');

// Define constants
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('VIEWS_PATH', APP_PATH . '/Views');
define('CONTROLLERS_PATH', APP_PATH . '/Controllers');
define('MODELS_PATH', APP_PATH . '/Models');
define('CONFIG_PATH', APP_PATH . '/Config');

// Helper function for base URL
function baseUrl($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    $baseUrl = $protocol . '://' . $host . $scriptName;
    return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
}

// Helper function for asset URLs
function asset($path) {
    return baseUrl('public/' . ltrim($path, '/'));
}

// Auto-loader
spl_autoload_register(function ($className) {
    $paths = [
        APP_PATH . '/Controllers/' . $className . '.php',
        APP_PATH . '/Models/' . $className . '.php',
        APP_PATH . '/Config/' . $className . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Include configuration
require_once CONFIG_PATH . '/Config.php';
require_once CONFIG_PATH . '/Language.php';

// Get language from URL or session
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? Config::DEFAULT_LANGUAGE;
if (in_array($lang, Config::SUPPORTED_LANGUAGES)) {
    $_SESSION['lang'] = $lang;
} else {
    $lang = Config::DEFAULT_LANGUAGE;
    $_SESSION['lang'] = $lang;
}

// Load language
Language::load($lang);

// Get route
$route = $_GET['route'] ?? '';

// Simple routing - all routes show single page
$controller = new HomeController();

switch (true) {
    case $route === 'api/contact':
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $controller->apiContact();
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;
    
    case $route === 'sitemap.xml':
        header('Content-Type: application/xml');
        $controller->sitemap();
        break;
    
    case $route === 'contact' && $_SERVER['REQUEST_METHOD'] === 'POST':
        $controller->submitContact();
        break;
    
    default:
        // Always show single page for any route
        $controller->index();
        break;
}