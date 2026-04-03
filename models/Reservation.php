<?php
class Reservation
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Compte toutes les réservations pour un client donné
    public function countByClient($client_id)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM reservations WHERE client_id = ?");
        $stmt->execute([$client_id]);
        return $stmt->fetchColumn();
    }

    // Compte les réservations pour un client avec un certain statut
    public function countByClientAndStatut($client_id, $statut)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM reservations WHERE client_id = ? AND statut = ?");
        $stmt->execute([$client_id, $statut]);
        return $stmt->fetchColumn();
    }

    // Compte toutes les réservations pour un conducteur
    public function countByConducteur($conducteur_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM reservations r
            JOIN trajets t ON r.trajet_id = t.id
            WHERE t.conducteur_id = ?
        ");
        $stmt->execute([$conducteur_id]);
        return $stmt->fetchColumn();
    }

    // Compte les réservations pour un conducteur avec un certain statut
    public function countByConducteurAndStatut($conducteur_id, $statut)
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM reservations r
            JOIN trajets t ON r.trajet_id = t.id
            WHERE t.conducteur_id = ? AND r.statut = ?
        ");
        $stmt->execute([$conducteur_id, $statut]);
        return $stmt->fetchColumn();
    }

    // Récupère les réservations détaillées d’un client
    public function getByClientDetailed($client_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT r.*, t.ville_depart, t.ville_arrivee, t.date_depart, t.heure_depart, t.prix,
                   u.name AS nom_conducteur
            FROM reservations r
            JOIN trajets t ON r.trajet_id = t.id
            JOIN users u ON t.conducteur_id = u.id
            WHERE r.client_id = ?
            ORDER BY t.date_depart ASC, t.heure_depart ASC
        ");
        $stmt->execute([$client_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère les réservations détaillées pour un conducteur
    public function getByConducteurDetailed($conducteur_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT r.*, t.ville_depart, t.ville_arrivee, t.date_depart, t.heure_depart, t.prix,
                   c.name AS nom_client
            FROM reservations r
            JOIN trajets t ON r.trajet_id = t.id
            JOIN users c ON r.client_id = c.id
            WHERE t.conducteur_id = ?
            ORDER BY t.date_depart ASC, t.heure_depart ASC
        ");
        $stmt->execute([$conducteur_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
