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

$comptesRendus = (new CompteRenduService(Db::connexion()))->listerPour($utilisateur);

Gabarit::entete('Mes comptes rendus', $utilisateur);
?>
  <ul>
    <?php foreach ($comptesRendus as $cr): ?>
    <li>
      <a href="compte-rendu.php?id=<?= (int) $cr['id'] ?>">
        <?= htmlspecialchars($cr['dateSeance']) ?> — <?= htmlspecialchars($cr['nom'] . ' ' . $cr['prenom']) ?>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
<?php Gabarit::pied();
