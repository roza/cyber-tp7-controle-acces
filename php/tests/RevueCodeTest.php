<?php

namespace Kineo\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/** Étapes 3 et 4 — revue de code automatique des pages. */
final class RevueCodeTest extends TestCase
{
    public static function pagesProtegees(): array
    {
        return [
            'patients.php'       => ['patients.php', 'patients.lister'],
            'comptes-rendus.php' => ['comptes-rendus.php', 'compte_rendu.lire'],
            'compte-rendu.php'   => ['compte-rendu.php', 'compte_rendu.lire'],
            'modifier.php'       => ['modifier.php', 'compte_rendu.modifier'],
            'comptes.php'        => ['comptes.php', 'comptes.gerer'],
        ];
    }

    /** Étape 3 — chaque page protégée vérifie le droit, côté serveur. */
    #[DataProvider('pagesProtegees')]
    public function testLaPageExigeLeBonDroit(string $page, string $action): void
    {
        $code = file_get_contents(__DIR__ . "/../public/$page");
        $this->assertMatchesRegularExpression(
            "/Autorisation::exiger\([^;]*'" . preg_quote($action, '/') . "'\s*\)/",
            $code,
            "$page doit appeler Autorisation::exiger(..., '$action')"
        );
    }

    /** Étape 4 — le rôle vient de la session (donc du serveur), jamais du navigateur. */
    public function testAucunePageNeFaitConfianceAUnCookie(): void
    {
        foreach (glob(__DIR__ . '/../public/*.php') as $fichier) {
            $this->assertStringNotContainsString(
                '$_COOKIE',
                file_get_contents($fichier),
                basename($fichier) . ' lit un cookie : le navigateur le contrôle'
            );
        }
        $this->assertStringNotContainsString(
            'setcookie(',
            file_get_contents(__DIR__ . '/../public/index.php'),
            'index.php ne doit plus déposer de cookie « role »'
        );
    }
}
