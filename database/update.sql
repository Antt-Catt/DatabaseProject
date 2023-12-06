--Commandes de mise à jour des tables

--AVIS
--ajoute un nouvel avis dans la table avis correspondante - les champs sont remplis à partir d'un formulaire rempli par l'utilisateur
INSERT INTO avis (id_trajet, auteur, destinataire, note, commentaire) VALUES (:id_trajet, :auteur, :destinataire, :note, :commentaire);

--ETAPES
--ajoute une nouvelle étape dans la table etape correspondante - les champs sont remplis à partir d'un formulaire rempli par l'utilisateur
INSERT INTO etape (duree, distance, id_trajet, ville_depart, ville_arrivee) VALUES (:duree, :distance, :id_trajet, :ville_depart, :ville_arrivee);

--STUDENTS
--ajoute un nouvel étudiant dans la table etudiant correspondante - les champs sont remplis à partir d'un formulaire rempli par l'utilisateur
INSERT INTO etudiant (nom_etudiant, prenom_etudiant) VALUES (:nom, :prenom);
--supprime un etudiant de la table etudiant à partir de son identifiant (renseigné par l'utilisateur dans un formulaire)
DELETE FROM etudiant WHERE id_etudiant = :id_etudiant;

--TRAJETS
--ajoute un nouveau trajet dans la table trajet correspondante - les champs sont remplis à partir d'un formulaire rempli par l'utilisateur
INSERT INTO trajet (instant_depart, frais_par_passager, conducteur, id_voiture) VALUES (:instant_depart, :frais_par_passager, :conducteur, :id_voiture);

--VILLES
--ajoute à la table ville une nouvelle ville - le champ de la table est rempli à partir d'un formulaire rempli par l'utilisateur
INSERT INTO ville (nom_ville) VALUES (:nom_ville);

--VOITURES
--ajoute une nouvelle voiture dans la table voiture correspondante - les champs sont remplis à partir d'un formulaire rempli par l'utilisateur
INSERT INTO voiture (type, couleur, nombre_de_places, etat, conducteur) VALUES (:type, :couleur, :ndp, :etat, :conducteur);
--supprime une voiture de la table voiture à partir de son identifiant (renseigné par l'utilisateur dans un formulaire)
DELETE FROM voiture WHERE id_voiture = :id_voiture;

