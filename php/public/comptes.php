<?php
require __DIR__ . '/../vendor/autoload.php';

use Kineo\Db;
use Kineo\Gabarit;

session_start();
if (!isset($_SESSION['utilisateur'])) {
    header('Location: index.php');
    exit;
}
$utilisateur = $_SESSION['utilisateur'];

// Page réservée à l'administrateur
if (($_COOKIE['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('Accès refusé.');
}

$req = Db::connexion()->prepare('SELECT login, nom, role FROM Utilisateur ORDER BY login');
$req->execute();
$comptes = $req->fetchAll();

Gabarit::entete('Comptes utilisateurs', $utilisateur);
?>
  <table border="1" cellpadding="4">
    <tr><th>Identifiant</th><th>Nom</th><th>Rôle</th></tr>
    <?php foreach ($comptes as $c): ?>
    <tr>
      <td><?= htmlspecialchars($c['login']) ?></td><td><?= htmlspecialchars($c['nom']) ?></td>
      <td><?= htmlspecialchars($c['role']) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
<?php Gabarit::pied();
