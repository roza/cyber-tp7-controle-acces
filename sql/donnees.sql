-- Mots de passe : a.martin / Genou-42, m.dalmeida / Epaule-17,
-- s.leroy / Kineo2026, c.petit / Admin-2026
INSERT INTO Utilisateur (id, login, nom, motDePasse, role) VALUES
 (1, 'a.martin',   'Alice Martin',     '$2y$12$5GHF4ksbVBQBwcHyxVEWj.rCqIF97LqdCKpRgdpPlrUMbEQ8rOJCO', 'praticien'),
 (2, 'm.dalmeida', 'Marc D''Almeida',  '$2y$12$2WucwSx8jAunVIiu0J0l/O1M28lhKtH8DtouovvwvCRZ4.2TxDuHm', 'praticien'),
 (3, 's.leroy',    'Sophie Leroy',     '$2y$12$oUuwANG0pnTze9dl2d6bie46nlyldGULura4HVdLohiUQ.NMiD1te', 'secretariat'),
 (4, 'c.petit',    'Camille Petit',    '$2y$12$Iq7vsM6uavjptQXnLVEGme9IJYN6MgvkvCkERVCeDM/QhTekooTYO', 'admin');

INSERT INTO Patient (id, nom, prenom, telephone, idPraticien) VALUES
 (1, 'N''Diaye',  'Awa',    '06 12 34 56 78', 1),
 (2, 'Durand',    'Paul',   '06 23 45 67 89', 1),
 (3, 'Lefebvre',  'Julie',  '06 34 56 78 90', 2),
 (4, 'Moreau',    'Hugo',   '06 45 67 89 01', 2);

INSERT INTO CompteRendu (id, idPatient, dateSeance, contenu) VALUES
 (1, 1, '2026-11-03', 'Entorse de la cheville droite. Travail proprioceptif, bonne progression.'),
 (2, 2, '2026-11-04', 'Lombalgie chronique. Renforcement du gainage, douleur 4/10.'),
 (3, 3, '2026-11-04', 'Rééducation post-opératoire du genou gauche (ligament croisé). Flexion 95°.'),
 (4, 4, '2026-11-05', 'Tendinopathie de l''épaule droite. Ondes de choc, séance 3 sur 6.'),
 (5, 1, '2026-11-10', 'Cheville droite : reprise de la course autorisée à faible intensité.');
