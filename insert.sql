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


--trajet
INSERT INTO trajet (instant_depart, frais_par_passager, conducteur, id_voiture) VALUES 
(TO_TIMESTAMP('13-OCT-1921-12-30-00', 'DD-MON-YYYY-HH-MM-SS'),30,1,1);

--etapes
INSERT INTO etape (duree, distance, id_trajet, ville_depart, ville_arrivee) VALUES 
(30, 35, 1, 1, 2);

--voiture
INSERT INTO voiture (type, couleur, nombre_de_places, etat, conducteur) VALUES 
(charette, vert, 5, neuf, 1);

--ville
INSERT INTO ville (id_ville) VALUES 
('Bordeaux'),
('Pessac'),
('Nantes'),
('Cognac'),
('Langon'),
('Rouen'),
('Montaigu'),
('Talence'),
('Mont-Saint-Aignan');

--avis
INSERT INTO avis VALUES
(1, 1, 2, 4, 'super');

--inscription
INSERT INTO inscription VALUES 
(2, 1, 1);


INSERT INTO voiture () VALUES 
INSERT INTO voiture () VALUES 
