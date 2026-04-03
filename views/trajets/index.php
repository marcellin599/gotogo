<h2>Trajets disponibles</h2>

<?php foreach ($trajets as $trajet): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong><?= htmlspecialchars($trajet['type']) ?></strong><br>
        <b><?= htmlspecialchars($trajet['ville_depart']) ?> → <?= htmlspecialchars($trajet['ville_arrivee']) ?></b><br>
        Départ : <?= htmlspecialchars($trajet['date_depart']) ?> à <?= htmlspecialchars($trajet['heure_depart']) ?><br>
        Prix : <?= number_format($trajet['prix'], 0, '', ' ') ?> FCFA<br>
        Conducteur : <?= htmlspecialchars($trajet['conducteur_name']) ?><br>
        <i><?= nl2br(htmlspecialchars($trajet['description'])) ?></i>
    </div>
<?php endforeach; ?>

<p><a href="index.php?page=dashboard">⬅ Retour tableau de bord</a></p>
<p><a href="index.php?page=reservation&trajet_id=<?= $trajet['id'] ?>">Réserver</a></p>
