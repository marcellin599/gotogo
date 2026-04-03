<head><h3>👤 Mon profil</h3>
<link rel="stylesheet" href="/css/style.css">
</head>

<p><strong>Nom :</strong> <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Non défini') ?></p>
<p><strong>Email :</strong> <?= htmlspecialchars($_SESSION['user']['email'] ?? 'Non défini') ?></p>
<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">✅ Profil mis à jour avec succès.</p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p style="color: red;">❌ <?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<h4>Modifier mon profil</h4>
<form method="POST" action="index.php?page=dashboard_client&sub=profil">
    <div>
        <label>Nom :</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($_SESSION['user']['name'] ?? '') ?>" required>
    </div>
    
    <div>
        <label>Email :</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>" required>
    </div>
    
    <button type="submit">Mettre à jour</button>
</form>

<p><a href="index.php?page=dashboard_client">← Retour au tableau de bord</a></p>