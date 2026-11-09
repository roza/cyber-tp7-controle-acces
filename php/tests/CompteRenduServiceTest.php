<?php

namespace Kineo\Tests;

use Kineo\CompteRenduService;

/**
 * Étapes 1 et 2 — un praticien n'accède qu'aux comptes rendus des patients
 * qu'il suit. a.martin suit les patients 1 et 2 (comptes rendus 1, 2 et 5) ;
 * m.dalmeida suit les patients 3 et 4 (comptes rendus 3 et 4).
 */
final class CompteRenduServiceTest extends BaseTestCase
{
    private CompteRenduService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CompteRenduService($this->pdo);
    }

    public function testLaListeNeContientQueLesPatientsSuivis(): void
    {
        $ids = array_column($this->service->listerPour($this->utilisateur('a.martin')), 'id');
        sort($ids);
        $this->assertSame([1, 2, 5], array_map('intval', $ids));
    }

    public function testUnPraticienLitLeCompteRenduDUnDeSesPatients(): void
    {
        $cr = $this->service->lire($this->utilisateur('a.martin'), 1);
        $this->assertNotNull($cr);
        $this->assertSame("N'Diaye", $cr['nom']);
    }

    public function testUnCompteRenduInexistantDonneNull(): void
    {
        $this->assertNull($this->service->lire($this->utilisateur('a.martin'), 999));
    }

    /** Étape 1 */
    public function testUnPraticienNeLitPasLeCompteRenduDUnPatientQuIlNeSuitPas(): void
    {
        $this->assertNull(
            $this->service->lire($this->utilisateur('a.martin'), 3),
            "a.martin ne suit pas Julie Lefebvre : le compte rendu n° 3 ne doit pas lui être renvoyé"
        );
    }

    /** Étape 1 */
    public function testLeSecretariatNeLitAucunCompteRendu(): void
    {
        $this->assertNull(
            $this->service->lire($this->utilisateur('s.leroy'), 1),
            "s.leroy ne suit aucun patient : aucun compte rendu ne doit lui être renvoyé"
        );
    }

    public function testUnPraticienModifieLeCompteRenduDUnDeSesPatients(): void
    {
        $this->assertTrue($this->service->modifier($this->utilisateur('a.martin'), 2, 'Nouveau texte'));
        $this->assertSame('Nouveau texte', $this->contenu(2));
    }

    /** Étape 2 */
    public function testUnPraticienNeModifiePasLeCompteRenduDUnAutre(): void
    {
        $avant = $this->contenu(3);
        $resultat = $this->service->modifier($this->utilisateur('a.martin'), 3, 'Texte falsifié');
        $this->assertFalse($resultat, 'modifier() doit renvoyer false');
        $this->assertSame($avant, $this->contenu(3), 'Le compte rendu n° 3 ne doit pas avoir changé');
    }
}
