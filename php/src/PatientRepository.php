<?php

namespace Kineo;

use PDO;

/** Liste administrative des patients (sans données de santé). */
final class PatientRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function tous(): array
    {
        $req = $this->pdo->prepare(
            'SELECT p.id, p.nom, p.prenom, p.telephone, u.nom AS praticien
               FROM Patient p JOIN Utilisateur u ON u.id = p.idPraticien
              ORDER BY p.nom, p.prenom'
        );
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
