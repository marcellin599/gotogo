<head>
    <h2>Publier un trajet</h2>
<link rel="stylesheet" href="/css/style.css">
</head>
<?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>

<form method="POST">
    <label>Type :</label>
    <select name="type" required>
        <option value="passager">Passager</option>
        <option value="colis">Livraison de colis</option>
    </select><br>

    <input type="text" name="ville_depart" placeholder="Ville de départ" required><br>
    <input type="text" name="ville_arrivee" placeholder="Ville d’arrivée" required><br>
    <input type="date" name="date_depart" required><br>
    <input type="time" name="heure_depart" required><br>
    <input type="number" name="nb_places" placeholder="Nombre de places" required><br>
    <input type="number" name="prix" step="0.01" placeholder="Prix (en FCFA)" required><br>
    <textarea name="description" placeholder="Description (facultatif)"></textarea><br>
    <button type="submit">Publier</button>
</form>

<p><a href="index.php?page=dashboard">⬅ Retour tableau de bord</a></p>
