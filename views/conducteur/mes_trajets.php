<head>
    <h2>🚗 Mes trajets publiés</h2>
<link rel="stylesheet" href="/css/style.css">

</head>


<table border="1">
    <tr>
        <th>Départ</th>
        <th>Arrivée</th>
        <th>Date</th>
        <th>Heure</th>
        <th>Places</th>
        <th>Prix</th>
    </tr>
    <?php if (!empty($trajets)): ?>
    <?php foreach ($trajets as $t): ?>
    <tr>
        <td><?= htmlspecialchars($t['ville_depart']) ?></td>
        <td><?= htmlspecialchars($t['ville_arrivee']) ?></td>
        <td><?= $t['date_depart'] ?></td>
        <td><?= $t['heure_depart'] ?></td>
        <td><?= $t['nb_places'] ?></td>
        <td><?= number_format($t['prix'], 2) ?> FCFA</td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr><td colspan="6">Aucun trajet trouvé.</td></tr>
<?php endif; ?>
</table>
