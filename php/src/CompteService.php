<?php

namespace Kineo;

use PDO;

/** Authentification. Pas à corriger dans ce TP (c'était le TP6). */
final class CompteService
{
    public function __construct(private PDO $pdo)
    {
    }

    /**
     * Renvoie l'utilisateur ['id', 'login', 'nom', 'role'] si le login et le
     * mot de passe sont corrects, null sinon.
     */
    public function authentifier(string $login, string $mdp): ?array
    {
        $req = $this->pdo->prepare(
            'SELECT id, login, nom, role, motDePasse FROM Utilisateur WHERE login = :login'
        );
        $req->bindValue(':login', $login, PDO::PARAM_STR);
        $req->execute();
        $ligne = $req->fetch(PDO::FETCH_ASSOC);

        if ($ligne === false || !password_verify($mdp, $ligne['motDePasse'])) {
            return null;
        }
        unset($ligne['motDePasse']);
        $ligne['id'] = (int) $ligne['id'];
        return $ligne;
    }
}
