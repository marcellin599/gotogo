<body>
    <div class="center-page">
        <div class="login-container">
            <link rel="stylesheet" href="/css/style.css">
            <div class="logo">🚗 Go<span style="color:#ff6b6b;">Togo</span></div>
            <h2>Connexion</h2>

            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Mot de passe" required><br>
                <button type="submit">Se connecter</button>
            </form>

            <p>Pas de compte ? <a href="index.php?page=register">Inscription</a></p>
        </div>
    </div>
</body>
