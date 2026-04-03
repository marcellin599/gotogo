<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = require __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Trajet.php';
require_once __DIR__ . '/../../models/Reservation.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

$trajetModel = new Trajet($pdo);
$reservationModel = new Reservation($pdo);
$user_id = $_SESSION['user']['id'];

// --- Gestion du profil ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['sub'] ?? '') === 'profil') {
    $nom = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if ($nom && $email) {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$nom, $email, $user_id]);
        $_SESSION['user']['name'] = $nom;
        $_SESSION['user']['email'] = $email;
        header("Location: index.php?page=dashboard_conducteur&sub=profil&success=1");
        exit;
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// --- Compteurs ---
$nbTrajets = $trajetModel->countByConducteur($user_id);
$nbAttente = $reservationModel->countByConducteurAndStatut($user_id, 'en_attente');
$nbAcceptees = $reservationModel->countByConducteurAndStatut($user_id, 'acceptee');

// --- Sous-pages ---
$sub = $_GET['sub'] ?? null;

include 'menu_conducteur.php';
?>

<?php if (!$sub): ?>
<div class="dashboard-container">
    <div class="dashboard-welcome">
        <img src="./images/conducteur-welcome.svg" alt="Bienvenue" class="dashboard-image">
        <link rel="stylesheet" href="/css/style.css">
        <div class="dashboard-text">
            <h2>👤 Tableau de bord conducteur</h2>
            <p>Bienvenue <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong> !</p>
        </div>
    </div>

    <div class="dashboard-stats card">
        <h3>📊 Mes infos</h3>
        <ul>
            <li>🚗 Trajets publiés : <strong><?= $nbTrajets ?></strong></li>
            <li>🛎️ Réservations en attente : <strong><?= $nbAttente ?></strong></li>
            <li>✅ Réservations acceptées : <strong><?= $nbAcceptees ?></strong></li>
        </ul>
    </div>

    <div class="dashboard-actions card">
        <h3>⚡ Actions rapides</h3>
        <ul>
            <li><a href="index.php?page=dashboard_conducteur&sub=publier">➕ Publier un trajet</a></li>
            <li><a href="index.php?page=dashboard_conducteur&sub=trajets">📄 Gérer mes trajets</a></li>
            <li><a href="index.php?page=dashboard_conducteur&sub=reservations">📥 Gérer mes réservations</a></li>
            <li><a href="index.php?page=logout">🚪 Déconnexion</a></li>
        </ul>
    </div>
</div>

<?php else: ?>
<?php
switch ($sub) {
    case 'publier':
        // Formulaire de création de trajet
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'conducteur_id' => $user_id,
                'type' => $_POST['type'] ?? '',
                'ville_depart' => $_POST['ville_depart'] ?? '',
                'ville_arrivee' => $_POST['ville_arrivee'] ?? '',
                'date_depart' => $_POST['date_depart'] ?? '',
                'heure_depart' => $_POST['heure_depart'] ?? '',
                'nb_places' => $_POST['nb_places'] ?? 0,
                'prix' => $_POST['prix'] ?? 0,
                'description' => $_POST['description'] ?? '',
            ];
            if ($trajetModel->create($data)) $message = "Trajet publié avec succès !";
            else $message = "Erreur lors de la publication.";
        }
        include __DIR__ . '/../trajets/create.php';
        break;

    case 'trajets':
        $trajets = array_filter($trajetModel->getAll(), fn($t) => $t['conducteur_id'] == $user_id);
        include __DIR__ . '/mes_trajets.php';
        break;

    case 'reservations':
        include 'reservations.php';
        break;

    case 'profil':
        include 'profil_conducteur.php';
        break;

    default:
        echo "<p>Erreur : page inconnue</p>";
        break;
}
?>
<?php endif; ?>