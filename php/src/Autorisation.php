<?php

namespace Kineo;

/**
 * Contrôle d'accès par rôles (RBAC) : qui a le droit de faire quoi.
 *
 * Les actions de l'application :
 *   'patients.lister'        voir la liste administrative des patients
 *   'compte_rendu.lire'      lire un compte rendu de séance
 *   'compte_rendu.modifier'  modifier un compte rendu de séance
 *   'comptes.gerer'          gérer les comptes utilisateurs
 */
final class Autorisation
{
    /** Étape 3 : la matrice des droits, rôle => actions autorisées. */
    private const DROITS = [
    ];

    /** Vrai si le rôle $role a le droit d'effectuer $action. */
    public static function peut(string $role, string $action): bool
    {
        return true;
    }

    /**
     * À appeler en tête de chaque page protégée : renvoie vers la connexion si
     * personne n'est connecté, répond 403 si le rôle n'a pas le droit.
     */
    public static function exiger(?array $utilisateur, string $action): array
    {
        if ($utilisateur === null) {
            header('Location: index.php');
            exit;
        }
        if (!self::peut($utilisateur['role'], $action)) {
            http_response_code(403);
            exit('Accès refusé.');
        }
        return $utilisateur;
    }
}
