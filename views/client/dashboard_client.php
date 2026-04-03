<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Import de la base de données et du modèle Reservation
$pdo = require __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Reservation.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=login');
    exit;
}

// Mise à jour du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['sub'] ?? '') === 'profil') {
    $nom = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nom && $email) {
        // Mise à jour SQL
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$nom, $email, $_SESSION['user']['id']]);

        // Mise à jour de la session
        $_SESSION['user']['name'] = $nom;
        $_SESSION['user']['email'] = $email;

        header("Location: index.php?page=dashboard_client&sub=profil&success=1");
        exit;
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}

// Menu client
include 'menu_client.php';

// Initialisation du modèle Reservation
$reservationModel = new Reservation($pdo);
$user_id = $_SESSION['user']['id'];

// Comptages pour le dashboard
$nbReservations = $reservationModel->countByClient($user_id);
$nbEnAttente = $reservationModel->countByClientAndStatut($user_id, 'en_attente');
$nbAcceptees = $reservationModel->countByClientAndStatut($user_id, 'acceptee');

$sub = $_GET['sub'] ?? null;
?>

<?php if (!$sub): ?>
<div class="dashboard-container">
    <div class="dashboard-welcome">
        <img src="/GoTogo/public/images/passager-welcome.svg" alt="Bienvenue" class="dashboard-image">
        <link rel="stylesheet" href="/GoTogo/public/css/style.css">
        <div class="dashboard-text">
            <h2>🎒 Tableau de bord passager</h2>
            <p>Bienvenue <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong> !</p>
        </div>
    </div>

    <div class="dashboard-stats card">
        <h3>📊 Mes infos</h3>
        <ul>
            <li>🛎️ Total de réservations : <strong><?= $nbReservations ?></strong></li>
            <li>⏳ Réservations en attente : <strong><?= $nbEnAttente ?></strong></li>
            <li>✅ Réservations acceptées : <strong><?= $nbAcceptees ?></strong></li>
        </ul>
    </div>

    <div class="dashboard-actions card">
        <h3>⚡ Actions rapides</h3>
        <ul>
            <li><a href="index.php?page=dashboard_client&sub=rechercher">🔍 Rechercher un trajet</a></li>
            <li><a href="index.php?page=dashboard_client&sub=reservations">📥 Mes réservations</a></li>
            <li><a href="index.php?page=dashboard_client&sub=profil">👤 Mon profil</a></li>
            <li><a href="index.php?page=logout">🚪 Déconnexion</a></li>
        </ul>
    </div>
</div>

<?php else: ?>
    <?php
    // Récupération détaillée si sous-page réservations
    if ($sub === 'reservations') {
        $reservations = $reservationModel->getByClientDetailed($user_id);
    }

    switch ($sub) {
        case 'rechercher':
            include 'rechercher_trajet.php';
            break;
        case 'reservations':
            include 'mes_reservations.php';
            break;
        case 'profil':
            include 'profil_client.php';
            break;
        default:
            echo "<p>Erreur : page inconnue</p>";
    }
    ?>
<?php endif; ?>