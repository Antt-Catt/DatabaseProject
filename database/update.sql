--Commandes de mise à jour des tables


--Etudiants
----Ajout d'un étudiant:
INSERT INTO etudiant (nom_etudiant, prenom_etudiant)
VALUES (nom, prenom);

----Suppresion étudiant:
DELETE FROM etudiant WHERE id_etudiant = id_etudiant;


-- Trajets/Etapes

----Ajout d'un trajet d'une ville A vers une ville B à un instant donné (le trajet peut présenté plusieurs étapes)
--ville arrivée
INSERT INTO ville (nom_ville) VALUES ('VILLE_ARRIVÉE');
--ville départ
INSERT INTO ville (nom_ville) VALUES ('VILLE_DÉPART');
--ajout d'un trajet
INSERT INTO trajet (instant_depart, frais_par_passager, conducteur, id_voiture) VALUES ((TO_TIMESTAMP('13-OCT-2006-12-30-00', 'DD-MON-YYYY-HH-MI-SS'), frais, conducteur, id_voiture));
--ajout de une ou plusieurs étapes
INSERT INTO etape (duree, distance, id_trajet, ville_depart, ville_arrivee) VALUES (duree (min), distance(km), id_trajet, ville_depart, ville_arrivee);



--Inscription d'un passager à un trajet

---- Mise à jour de l'horaire
UPDATE trajet
SET instant_depart = ;





-- Voitures

-- Mise à jour du nombre_de_places :
UPDATE 


//