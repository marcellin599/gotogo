<?php
class Trajet
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO trajets (conducteur_id, type, ville_depart, ville_arrivee, date_depart, heure_depart, nb_places, prix, description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['conducteur_id'],
            $data['type'],
            $data['ville_depart'],
            $data['ville_arrivee'],
            $data['date_depart'],
            $data['heure_depart'],
            $data['nb_places'],
            $data['prix'],
            $data['description']
        ]);
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("
            SELECT t.*, u.name AS conducteur_name
            FROM trajets t
            JOIN users u ON t.conducteur_id = u.id
            ORDER BY date_depart ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByConducteur($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM trajets WHERE conducteur_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn();
    }

    // Recherche les trajets par départ, arrivée et date
public function search($depart, $destination, $date)
{
    $stmt = $this->pdo->prepare("
        SELECT t.*, u.name AS conducteur_name
        FROM trajets t
        JOIN users u ON t.conducteur_id = u.id
        WHERE ville_depart LIKE ? AND ville_arrivee LIKE ? AND date_depart = ?
        AND nb_places > 0
        ORDER BY date_depart ASC, heure_depart ASC
    ");
    $stmt->execute([
        "%$depart%",
        "%$destination%",
        $date
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}
?>