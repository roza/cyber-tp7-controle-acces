<?php
// Connexion — lancer : php -S localhost:8000 -t public
require __DIR__ . '/../vendor/autoload.php';

use Kineo\CompteService;
use Kineo\Db;
use Kineo\Gabarit;

session_start();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateur = (new CompteService(Db::connexion()))
        ->authentifier($_POST['login'] ?? '', $_POST['mdp'] ?? '');
    if ($utilisateur !== null) {
        session_regenerate_id(true);
        $_SESSION['utilisateur'] = $utilisateur;
        // le rôle, gardé aussi dans un cookie pour la page d'administration
        setcookie('role', $utilisateur['role']);
        $accueil = ['praticien' => 'comptes-rendus.php', 'secretariat' => 'patients.php', 'admin' => 'comptes.php'];
        header('Location: ' . $accueil[$utilisateur['role']]);
        exit;
    }
    $message = 'Identifiant ou mot de passe incorrect.';
}

Gabarit::entete('Connexion');
?>
  <form method="post">
    <p><label>Identifiant <input name="login" required></label></p>
    <p><label>Mot de passe <input name="mdp" type="password" required></label></p>
    <p><button>Se connecter</button></p>
  </form>
  <p><?= htmlspecialchars($message) ?></p>
<?php Gabarit::pied();
