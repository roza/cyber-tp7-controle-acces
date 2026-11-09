<?php

namespace Kineo\Tests;

use Kineo\Autorisation;
use PHPUnit\Framework\TestCase;

/** Étape 3 — la matrice des droits (RBAC). */
final class AutorisationTest extends TestCase
{
    public function testUnPraticienListeLesPatientsLitEtModifieLesComptesRendus(): void
    {
        $this->assertTrue(Autorisation::peut('praticien', 'patients.lister'));
        $this->assertTrue(Autorisation::peut('praticien', 'compte_rendu.lire'));
        $this->assertTrue(Autorisation::peut('praticien', 'compte_rendu.modifier'));
    }

    public function testLeSecretariatVoitLesPatientsMaisPasLesComptesRendus(): void
    {
        $this->assertTrue(Autorisation::peut('secretariat', 'patients.lister'));
        $this->assertFalse(Autorisation::peut('secretariat', 'compte_rendu.lire'));
        $this->assertFalse(Autorisation::peut('secretariat', 'compte_rendu.modifier'));
    }

    public function testSeulLAdministrateurGereLesComptes(): void
    {
        $this->assertTrue(Autorisation::peut('admin', 'comptes.gerer'));
        $this->assertFalse(Autorisation::peut('praticien', 'comptes.gerer'));
        $this->assertFalse(Autorisation::peut('secretariat', 'comptes.gerer'));
    }

    public function testLAdministrateurNAccedePasAuxDonneesDeSante(): void
    {
        $this->assertFalse(Autorisation::peut('admin', 'compte_rendu.lire'));
        $this->assertFalse(Autorisation::peut('admin', 'compte_rendu.modifier'));
    }

    public function testCeQuiNEstPasPrevuEstRefuse(): void
    {
        $this->assertFalse(Autorisation::peut('stagiaire', 'patients.lister'), 'rôle inconnu');
        $this->assertFalse(Autorisation::peut('admin', 'base.supprimer'), 'action inconnue');
    }
}
