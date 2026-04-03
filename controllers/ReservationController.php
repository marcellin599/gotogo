<?php
require_once __DIR__ . '/../models/Reservation.php';

class ReservationController
{
    public static function reserver()
    {
        global $pdo;

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $client_id = $_SESSION['user']['id'];
        $trajet_id = $_GET['trajet_id'] ?? null;
        $message = '';

        if ($trajet_id) {
            $reservationModel = new Reservation($pdo);
            $success = $reservationModel->create($trajet_id, $client_id);
            $message = $success
                ? "Réservation enregistrée ✅"
                : "Vous avez déjà réservé ce trajet ❌";
        }

        include __DIR__ . '/../views/trajets/reservation_message.php';
    }
    public static function mesReservations()
{
    global $pdo;

    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $client_id = $_SESSION['user']['id'];
    $reservationModel = new Reservation($pdo);
    $reservations = $reservationModel->getByClient($client_id);

    include __DIR__ . '/../views/reservations/client.php';
}
public static function reservationsConducteur() {
    global $pdo;

    if (!isset($_SESSION['user'])) {
        header('Location: index.php?page=login');
        exit;
    }

    $conducteur_id = $_SESSION['user']['id'];

    $sql = "SELECT r.id AS reservation_id, r.statut, u.nom, u.email, t.depart, t.destination, t.date_depart
            FROM reservations r
            JOIN trajets t ON r.trajet_id = t.id
            JOIN utilisateurs u ON r.utilisateur_id = u.id
            WHERE t.utilisateur_id = :conducteur_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['conducteur_id' => $conducteur_id]);
    $reservations = $stmt->fetchAll();

    include __DIR__ . '/../views/conducteur/reservations.php';
}

public static function updateStatut() {
    global $pdo;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['reservation_id'];
        $statut = $_POST['action'];

        $sql = "UPDATE reservations SET statut = :statut WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'statut' => $statut,
            'id' => $id
        ]);

        header('Location: index.php?page=reservations_conducteur');
        exit;
    }
}


}
?>