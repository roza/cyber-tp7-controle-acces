# TP7 — Contrôle d'accès

**BTS SIO 2ᵉ année · option SLAM · Bloc 3 — cybersécurité**

L'application **KinéGest** authentifie correctement ses utilisateurs… mais ne
vérifie presque jamais **ce qu'ils ont le droit de faire**. Un praticien lit les
comptes rendus des patients d'un confrère en changeant un numéro dans l'adresse,
la secrétaire lit des données de santé, et un cookie suffit pour devenir
administrateur. Votre travail : **vérifier les droits côté serveur, à chaque
requête**. Les tests vous guident ; l'énoncé complet est dans le PDF du TP.

> ⚠️ Les attaques de ce TP se font **uniquement sur votre copie de
> l'application**, jamais sur un site réel (article 323-1 du Code pénal).

## 1. Récupérer le projet

1. Sur la page de ce dépôt : **Use this template** › **Create a new repository**.
2. Gardez le nom `cyber-tp7-controle-acces`, cochez **Private**.
3. **Settings** › **Collaborators** : ajoutez `roza`.
4. Clonez **votre** dépôt et ouvrez le **dossier** dans VS Code.

Sans PHP sur votre poste : **Code** › **Codespaces** › **Create codespace on
main** (pensez à l'arrêter en fin de séance).

## 2. Lancer

Prérequis : PHP 8.2 ou plus avec `pdo_sqlite` (vérifiez avec `php -m`), et
Composer.

```sh
cd php
composer install
composer init-db                    # crée (ou remet à zéro) la base SQLite var/kinegest.sqlite
vendor/bin/phpunit                  # les tests
php -S localhost:8000 -t public     # l'application
```

| Identifiant | Mot de passe | Rôle | Suit les patients |
|---|---|---|---|
| `a.martin` | `Genou-42` | praticien | N'Diaye, Durand |
| `m.dalmeida` | `Epaule-17` | praticien | Lefebvre, Moreau |
| `s.leroy` | `Kineo2026` | secrétariat | — |
| `c.petit` | `Admin-2026` | administrateur | — |

*Une attaque a abîmé les données ? `composer init-db` remet la base à zéro.*

## 3. L'intégration continue

À chaque `git push`, GitHub lance les tests (onglet **Actions**). **Au départ,
plusieurs tests sont rouges : c'est normal.** Le TP est terminé quand tout est vert.

## Organisation

```
sql/                              schéma (Utilisateur, Patient, CompteRendu) et données
php/src/CompteRenduService.php    lire, lister et modifier les comptes rendus
php/src/Autorisation.php          la matrice des droits par rôle (RBAC)
php/src/CompteService.php         l'authentification (déjà correcte)
php/public/                       les pages
php/tests/                        tests PHPUnit
```
