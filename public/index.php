
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/TrajetController.php';
require_once __DIR__ . '/../controllers/ReservationController.php';


$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'login':
        AuthController::login();
        break;
    case 'register':
        AuthController::register();
        break;
    case 'logout':
        AuthController::logout();
        break;
    case 'dashboard':
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    if ($_SESSION['user']['role'] === 'conducteur') {
        header('Location: index.php?page=dashboard_conducteur');
    } else {
        header('Location: index.php?page=dashboard_client');
    }
    break;

    case 'trajet-create':
        TrajetController::create();
        break;
    case 'trajets':
    TrajetController::index();
    break;
    case 'reservation':
    ReservationController::reserver();
    break;
    case 'mes-reservations':
    ReservationController::mesReservations();
    break;
    case 'reservations_conducteur':
        ReservationController::reservationsConducteur();
        break;
    case 'update_reservation':
        ReservationController::updateStatut();
        break;
    case 'dashboard_conducteur':
    include '../views/conducteur/dashboard_conducteur.php';
    break;
    case 'dashboard_client':
    include('../views/client/dashboard_client.php');
    break;
    case 'mes-trajets':
    TrajetController::mesTrajets();
    break;

    default:
        echo "Page introuvable.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>GoTogo 3D</title>
    <link rel="stylesheet" href="./css/style.css">

    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.139.2/build/three.module.js",
                "three/examples/jsm/": "https://unpkg.com/three@0.139.2/examples/jsm/"
            }
        }
    </script>
</head>
<body>

    <!-- La scène 3D en fond -->
    <div id="scene-container"></div>

    <!-- Charger le script main.js en module -->
    <script type="module" src="./js/main.js"></script>
</body>
</html>