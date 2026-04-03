<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>GoTogo 3D</title>
    <link rel="stylesheet" href="./css/style.css">

    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.139.2/build/three.module.js",
                "three/examples/jsm/": "https://unpkg.com/three@0.139.2/examples/jsm/"
            }
        }
    </script>
</head>
<body>

    <!-- La scène 3D en fond -->
    <div id="scene-container"></div>

    <!-- Menu client -->
    <?php include '../views/client/menu_client.php'; ?>
    
    <h2>🚗 Scène 3D GoTogo</h2>

    <!-- Charger le script main.js en module -->
    <script type="module" src="./js/main.js"></script>
</body>
</html>
