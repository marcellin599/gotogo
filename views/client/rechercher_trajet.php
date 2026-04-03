<?php
// Démarre la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/Trajet.php';

$pdo = require __DIR__ . '/../../config/database.php';
$trajetModel = new Trajet($pdo);

$trajets = []; // Initialisation des résultats

// Si le formulaire est soumis
if (!empty($_GET['depart']) && !empty($_GET['destination']) && !empty($_GET['date'])) {
    $depart = trim($_GET['depart']);
    $destination = trim($_GET['destination']);
    $date = $_GET['date'];

    // Méthode de recherche dans la classe Trajet (à créer si pas déjà fait)
    $trajets = $trajetModel->search($depart, $destination, $date);
}
?>

<head>
    <h3>🔍 Rechercher un trajet</h3>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
<form method="GET" action="index.php">
    <input type="hidden" name="page" value="dashboard_client">
    <input type="hidden" name="sub" value="rechercher">
    
    <div>
        <label>Départ :</label>
        <input type="text" name="depart" placeholder="Ville de départ" required
               value="<?= htmlspecialchars($_GET['depart'] ?? '') ?>">
    </div>
    
    <div>
        <label>Destination :</label>
        <input type="text" name="destination" placeholder="Ville d'arrivée" required
               value="<?= htmlspecialchars($_GET['destination'] ?? '') ?>">
    </div>
    
    <div>
        <label>Date :</label>
        <input type="date" name="date" required value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
    </div>
    
    <button type="submit">Rechercher</button>
</form>

<?php if (!empty($trajets)): ?>
    <h3>Résultats :</h3>
    <table border="1">
        <tr>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Places dispo</th>
            <th>Prix</th>
        </tr>
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
    </table>
<?php elseif ($_GET): ?>
    <p>Aucun trajet trouvé pour cette recherche.</p>
<?php endif; ?>


<p><a href="index.php?page=dashboard_client">← Retour au tableau de bord</a></p>
</body>