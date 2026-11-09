<?php

namespace Kineo;

/** En-tête et pied des pages. Pas à corriger. */
final class Gabarit
{
    public static function entete(string $titre, ?array $utilisateur = null): void
    {
        $t = htmlspecialchars($titre);
        echo "<!doctype html>\n<html lang=\"fr\">\n<head><meta charset=\"utf-8\"><title>KinéGest — $t</title></head>\n<body>\n";
        echo "<p><strong>KinéGest</strong>";
        if ($utilisateur !== null) {
            echo ' · ' . htmlspecialchars($utilisateur['nom']) . ' (' . htmlspecialchars($utilisateur['role']) . ')';
            // Le menu n'affiche que les liens utiles au rôle : c'est du confort,
            // pas une protection.
            $liens = [
                'praticien'   => ['comptes-rendus.php' => 'Mes comptes rendus', 'patients.php' => 'Patients'],
                'secretariat' => ['patients.php' => 'Patients'],
                'admin'       => ['comptes.php' => 'Comptes'],
            ][$utilisateur['role']] ?? [];
            foreach ($liens as $url => $libelle) {
                echo " · <a href=\"$url\">$libelle</a>";
            }
            echo ' · <a href="deconnexion.php">Déconnexion</a>';
        }
        echo "</p>\n<h1>$t</h1>\n";
    }

    public static function pied(): void
    {
        echo "</body>\n</html>\n";
    }
}
