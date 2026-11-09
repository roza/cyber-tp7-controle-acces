<?php

namespace Kineo\Tests;

use Kineo\Schema;
use PDO;
use PHPUnit\Framework\TestCase;

/** Chaque test repart d'une base SQLite neuve, en mémoire. */
abstract class BaseTestCase extends TestCase
{
    protected PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        Schema::initialiser($this->pdo);
    }

    /** L'utilisateur connecté, tel que la session le contient. */
    protected function utilisateur(string $login): array
    {
        $req = $this->pdo->prepare('SELECT id, login, nom, role FROM Utilisateur WHERE login = ?');
        $req->execute([$login]);
        $u = $req->fetch();
        $u['id'] = (int) $u['id'];
        return $u;
    }

    protected function contenu(int $idCompteRendu): string
    {
        $req = $this->pdo->prepare('SELECT contenu FROM CompteRendu WHERE id = ?');
        $req->execute([$idCompteRendu]);
        return $req->fetchColumn();
    }
}
