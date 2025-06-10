<?php
// Punto de entrada principal de la aplicación

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'showLogin';

$controllerClass = ucfirst($controller) . "Controller";
$controllerFile = __DIR__ . "/../controllers/{$controllerClass}.php";

// Verifica si el archivo del controlador existe
if (!file_exists($controllerFile)) {
    die("Error: El controlador '$controllerClass' no existe en '$controllerFile'.");
}

require_once $controllerFile;

// Verifica si la clase está correctamente definida en el archivo requerido
if (!class_exists($controllerClass)) {
    die("Error: La clase '$controllerClass' no está definida dentro de '$controllerFile'.");
}

$controllerInstance = new $controllerClass();

// Manejo de solicitudes POST y GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['id'])) {
        $controllerInstance->$action($_GET['id'], ...array_values($_POST));
    } else {
        $controllerInstance->$action(...array_values($_POST));
    }
} else {
    if (isset($_GET['id'])) {
        $controllerInstance->$action($_GET['id']);
    } else {
        $controllerInstance->$action();
    }
}
