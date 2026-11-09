<?php
require __DIR__ . '/../vendor/autoload.php';

use Kineo\Db;
use Kineo\Gabarit;
use Kineo\PatientRepository;

session_start();
if (!isset($_SESSION['utilisateur'])) {
    header('Location: index.php');
    exit;
}
$utilisateur = $_SESSION['utilisateur'];

$patients = (new PatientRepository(Db::connexion()))->tous();

Gabarit::entete('Patients', $utilisateur);
?>
  <table border="1" cellpadding="4">
    <tr><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Praticien</th></tr>
    <?php foreach ($patients as $p): ?>
    <tr>
      <td><?= htmlspecialchars($p['nom']) ?></td><td><?= htmlspecialchars($p['prenom']) ?></td>
      <td><?= htmlspecialchars($p['telephone']) ?></td><td><?= htmlspecialchars($p['praticien']) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
<?php Gabarit::pied();
