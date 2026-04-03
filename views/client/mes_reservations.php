<?php
require_once __DIR__ . '/../../models/Reservation.php';
$pdo = require __DIR__ . '/../../config/database.php';
$reservationModel = new Reservation($pdo);
$user_id = $_SESSION['user']['id'];

// Récupère les réservations détaillées du client
$reservations = $reservationModel->getByClientDetailed($user_id);
?>

<head>
    <h2>📥 Mes réservations</h2>
    <link rel="stylesheet" href="/css/style.css">
</head>

<?php if (empty($reservations)): ?>
    <p>Vous n’avez encore réservé aucun trajet.</p>
<?php else: ?>
    <table border="1" cellspacing="0" cellpadding="8">
        <tr>
            <th>Départ</th>
            <th>Destination</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Conducteur</th>
            <th>Prix</th>
            <th>Statut</th>
        </tr>
        <?php foreach ($reservations as $res): ?>
           <tr>
              <td><?= htmlspecialchars($res['ville_depart'] ?? '') ?></td>
              <td><?= htmlspecialchars($res['ville_arrivee'] ?? '') ?></td>
              <td><?= htmlspecialchars($res['date_depart'] ?? '') ?></td>
              <td><?= htmlspecialchars($res['heure_depart'] ?? '') ?></td>
              <td><?= htmlspecialchars($res['nom_conducteur'] ?? $res['conducteur_name'] ?? '') ?></td>
              <td><?= number_format($res['prix'] ?? 0, 2) ?> FCFA</td>
              <td>
                <?= match ($res['statut'] ?? '') {
                    'en_attente' => '⏳ En attente',
                    'acceptee' => '✅ Acceptée',
                    'refusee' => '❌ Refusée',
                    default => '⏺ Inconnu'
                } ?>
              </td>
           </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<p><a href="index.php?page=dashboard_client">← Retour au tableau de bord</a></p>