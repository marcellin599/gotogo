<head><h2>Inscription</h2>
<link rel="stylesheet" href="/css/style.css">
</head>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="POST" action="index.php?page=register">
    <input type="text" name="name" placeholder="Nom" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <label>Je suis :</label>
    <select name="role" required>
        <option value="client">Passager</option>
        <option value="conducteur">Conducteur</option>
    </select><br>
    <button type="submit">S'inscrire</button>
</form>

<p>Déjà un compte ? <a href="index.php?page=login">Connexion</a></p>
