<?php

namespace Kineo;

use PDO;

/**
 * Les comptes rendus de séance : des données de santé.
 * Règle métier : un praticien n'accède qu'aux comptes rendus des patients
 * qu'il suit (Patient.idPraticien).
 *
 * $utilisateur est l'utilisateur connecté : ['id', 'login', 'nom', 'role'].
 */
final class CompteRenduService
{
    public function __construct(private PDO $pdo)
    {
    }

    /** Les comptes rendus des patients suivis par $utilisateur, du plus récent au plus ancien. */
    public function listerPour(array $utilisateur): array
    {
        $req = $this->pdo->prepare(
            'SELECT cr.id, cr.dateSeance, p.nom, p.prenom
               FROM CompteRendu cr JOIN Patient p ON p.id = cr.idPatient
              WHERE p.idPraticien = :idPraticien
              ORDER BY cr.dateSeance DESC'
        );
        $req->bindValue(':idPraticien', $utilisateur['id'], PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Le compte rendu n° $id, ou null s'il n'existe pas. */
    public function lire(array $utilisateur, int $id): ?array
    {
        $req = $this->pdo->prepare(
            'SELECT cr.id, cr.dateSeance, cr.contenu, p.nom, p.prenom
               FROM CompteRendu cr JOIN Patient p ON p.id = cr.idPatient
              WHERE cr.id = :id'
        );
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        return $ligne === false ? null : $ligne;
    }

    /** Remplace le contenu du compte rendu n° $id. Renvoie true si une ligne a été modifiée. */
    public function modifier(array $utilisateur, int $id, string $contenu): bool
    {
        $req = $this->pdo->prepare('UPDATE CompteRendu SET contenu = :contenu WHERE id = :id');
        $req->bindValue(':contenu', $contenu, PDO::PARAM_STR);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        return $req->rowCount() > 0;
    }
}
