-- ============================================================
--    suppression des donnees
-- ============================================================

TRUNCATE etudiant, avis, trajet, etape, inscription, voiture, ville RESTART IDENTITY;

-- ============================================================
--    creation des donnees
-- ============================================================

INSERT INTO etudiant (nom_etudiant, prenom_etudiant) VALUES 
('SAUTET'     , 'CLAUDE'         ),
('PINOTEAU'   , 'CLAUDE'         ),
('DAVOY'      , 'ERIC'           ),
('ZIDI'       , 'CLAUDE'         ),
('AUTAN-LARA' , 'CLAUDE'         ),
('ROHMER'     , 'ERIC'           ),
('MALLE'      , 'LOUIS'          ),
('BESSON'     , 'LUC'            ),
('PREMINGER'  , 'OTTO'           ),
('BEINEIX'    , 'JEAN-JACQUES'   ),
('GERONIMI'   , 'C.'             ),
('LYNE'       , 'ADRIAN'         ),
('TRUFFAUT'   , 'FRANCOIS'       ),
('COCTEAU'    , 'JEAN'           );


--voiture
INSERT INTO voiture (type, couleur, nombre_de_places, etat, conducteur) VALUES 
('CHARETTE', 'VERT', 5, 'NEUF', 1),
('4X4', 'ORANGE', 4, 'NEUF', 2),
('ELECTRIQUE', 'ORANGE', 4, 'NEUF', 1),
('FAMILIALE', 'ROUGE', 10, 'NEUF', 3),
('4X4', 'NOIR', 5, 'NEUF', 4),
('ELECTRIQUE', 'BLANC', 3, 'VIEUX', 5);



--trajet
INSERT INTO trajet (instant_depart, frais_par_passager, conducteur, id_voiture) VALUES 
(TO_TIMESTAMP('13-OCT-1921-12-30-00', 'DD-MON-YYYY-HH-MI-SS'),30,1,1),
(TO_TIMESTAMP('11-JAN-1975-10-10-00', 'DD-MON-YYYY-HH-MI-SS'),5,4,2);


--ville
INSERT INTO ville (nom_ville) VALUES 
('BORDEAUX'),
('PESSAC'),
('NANTES'),
('COGNAC'),
('LANGON'),
('ROUEN'),
('MONTAIGU'),
('TALENCE'),
('MONT-SAINT-AIGNAN');

--etapes
INSERT INTO etape (duree, distance, id_trajet, ville_depart, ville_arrivee) VALUES 
(30, 35, 1, 1, 2),
(400, 100, 2, 1, 3),
(50, 35, 2, 1, 7),
(350, 65, 2, 7, 3);



--avis
INSERT INTO avis VALUES
(1, 1, 2, 4, 'super');

--inscription
INSERT INTO inscription VALUES 
(2, 1),
(5, 2),
(6, 2),
(7, 2);



-- INSERT INTO voiture () VALUES 
-- INSERT INTO voiture () VALUES 
commit;
