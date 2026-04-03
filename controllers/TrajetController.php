<?php
require_once __DIR__ . '/../models/Trajet.php';

class TrajetController
{
    public static function create()
    {
        global $pdo;
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'conducteur_id' => $_SESSION['user']['id'],
                'type' => $_POST['type'],
                'ville_depart' => $_POST['ville_depart'],
                'ville_arrivee' => $_POST['ville_arrivee'],
                'date_depart' => $_POST['date_depart'],
                'heure_depart' => $_POST['heure_depart'],
                'nb_places' => $_POST['nb_places'],
                'prix' => $_POST['prix'],
                'description' => $_POST['description']
            ];

            $trajetModel = new Trajet($pdo);
            if ($trajetModel->create($data)) {
                $message = "Trajet publié avec succès.";
            } else {
                $message = "Erreur lors de la publication.";
            }
        }

        include __DIR__ . '/../views/trajets/create.php';
    }
    public static function index()
{
    global $pdo;
    $trajetModel = new Trajet($pdo);
    $trajets = $trajetModel->getAll();

    include __DIR__ . '/../views/trajets/index.php';
}
public static function mesTrajets() {
    global $pdo;

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'conducteur') {
        echo "⛔ Accès refusé : seuls les conducteurs peuvent créer un trajet.";
        exit;
    }

    $conducteur_id = $_SESSION['user']['id'];
    $stmt = $pdo->prepare("SELECT * FROM trajets WHERE conducteur_id = ?");
    $stmt->execute([$conducteur_id]);
    $trajets = $stmt->fetchAll();

    include __DIR__ . '/../views/conducteur/mes_trajets.php';
}

}
?>