<h2>Mes Réservations</h2>

<?php if (empty($reservations)): ?>
    <p>Vous n'avez pas encore réservé de trajet.</p>
<?php else: ?>
    <?php foreach ($reservations as $r): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <b><?= htmlspecialchars($r['ville_depart']) ?> → <?= htmlspecialchars($r['ville_arrivee']) ?></b><br>
            Date : <?= htmlspecialchars($r['date_depart']) ?> à <?= htmlspecialchars($r['heure_depart']) ?><br>
            Conducteur : <?= htmlspecialchars($r['conducteur']) ?><br>
            Prix : <?= number_format($r['prix'], 0, '', ' ') ?> FCFA<br>
            Statut : <?= ucfirst($r['statut']) ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<p><a href="index.php?page=dashboard">⬅ Retour tableau de bord</a></p>
