<head><h2>Mes réservations reçues</h2>
<link rel="stylesheet" href="/css/style.css">
<</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ccc;
    }

    button {
        margin-right: 5px;
        padding: 5px 10px;
    }
</style>

<table border="1">
    <tr>
        <th>Passager</th>
        <th>Email</th>
        <th>Départ</th>
        <th>Destination</th>
        <th>Date</th>
        <th>Statut</th>
        <th>Action</th>
    </tr>
    <?php if (!empty($trajets)): ?>
    <?php foreach ($reservations as $res): ?>
        <tr>
            <td><?= htmlspecialchars($res['nom']) ?></td>
            <td><?= htmlspecialchars($res['email']) ?></td>
            <td><?= htmlspecialchars($res['depart']) ?></td>
            <td><?= htmlspecialchars($res['destination']) ?></td>
            <td><?= htmlspecialchars($res['date_depart']) ?></td>
            <td><?= $res['statut'] ?></td>
            <td>
                <?php if ($res['statut'] === 'en_attente'): ?>
                    <form method="POST" action="index.php?page=Reservation">
                         <input type="hidden" name="reservation_id" value="<?= $res['reservation_id'] ?>">
                         <button name="action" value="acceptee">✅ Accepter</button>
                         <button name="action" value="refusee">❌ Refuser</button>
                    </form>
                <?php else: ?>
                    <?= ucfirst($res['statut']) ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr><td colspan="6">Aucune reservation trouvé.</td></tr>
<?php endif; ?>
</table>
