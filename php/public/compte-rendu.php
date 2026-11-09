<?php
require __DIR__ . '/../vendor/autoload.php';

use Kineo\CompteRenduService;
use Kineo\Db;
use Kineo\Gabarit;

session_start();
if (!isset($_SESSION['utilisateur'])) {
    header('Location: index.php');
    exit;
}
$utilisateur = $_SESSION['utilisateur'];

$id = (int) ($_GET['id'] ?? 0);
$cr = (new CompteRenduService(Db::connexion()))->lire($utilisateur, $id);
if ($cr === null) {
    http_response_code(404);
    exit('Compte rendu introuvable.');
}

Gabarit::entete('Compte rendu', $utilisateur);
?>
  <p><strong><?= htmlspecialchars($cr['nom'] . ' ' . $cr['prenom']) ?></strong>
     — séance du <?= htmlspecialchars($cr['dateSeance']) ?></p>
  <blockquote><?= nl2br(htmlspecialchars($cr['contenu'])) ?></blockquote>
  <p><a href="modifier.php?id=<?= (int) $cr['id'] ?>">Modifier</a> ·
     <a href="comptes-rendus.php">Retour</a></p>
<?php Gabarit::pied();
