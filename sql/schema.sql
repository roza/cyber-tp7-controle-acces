-- KinéGest, version simplifiée pour le TP7 : comptes, patients, comptes rendus.
DROP TABLE IF EXISTS CompteRendu;
DROP TABLE IF EXISTS Patient;
DROP TABLE IF EXISTS Utilisateur;

CREATE TABLE Utilisateur (
    id         INTEGER PRIMARY KEY,
    login      VARCHAR(50)  NOT NULL UNIQUE,
    nom        VARCHAR(100) NOT NULL,
    motDePasse VARCHAR(255) NOT NULL,
    role       VARCHAR(20)  NOT NULL CHECK (role IN ('praticien', 'secretariat', 'admin'))
);

-- idPraticien : le kinésithérapeute qui suit le patient
CREATE TABLE Patient (
    id          INTEGER PRIMARY KEY,
    nom         VARCHAR(100) NOT NULL,
    prenom      VARCHAR(100) NOT NULL,
    telephone   VARCHAR(20),
    idPraticien INTEGER NOT NULL REFERENCES Utilisateur(id)
);

-- Données de santé : seul le praticien qui suit le patient y accède.
CREATE TABLE CompteRendu (
    id         INTEGER PRIMARY KEY,
    idPatient  INTEGER NOT NULL REFERENCES Patient(id),
    dateSeance DATE NOT NULL,
    contenu    TEXT NOT NULL
);
