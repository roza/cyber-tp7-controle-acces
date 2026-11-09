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
$service = new CompteRenduService(Db::connexion());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    $service->modifier($utilisateur, $id, $_POST['contenu'] ?? '');
    header('Location: compte-rendu.php?id=' . $id);
    exit;
}

$cr = $service->lire($utilisateur, (int) ($_GET['id'] ?? 0));
if ($cr === null) {
    http_response_code(404);
    exit('Compte rendu introuvable.');
}

Gabarit::entete('Modifier un compte rendu', $utilisateur);
?>
  <p><?= htmlspecialchars($cr['nom'] . ' ' . $cr['prenom']) ?> — séance du <?= htmlspecialchars($cr['dateSeance']) ?></p>
  <form method="post">
    <input type="hidden" name="id" value="<?= (int) $cr['id'] ?>">
    <p><textarea name="contenu" rows="6" cols="70"><?= htmlspecialchars($cr['contenu']) ?></textarea></p>
    <p><button>Enregistrer</button></p>
  </form>
<?php Gabarit::pied();
