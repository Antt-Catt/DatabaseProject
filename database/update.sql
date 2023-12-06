-- ============================================================
--   Mise à jour des tables                                      
-- ============================================================


-- Les valeurs à renseigner par l'utilisateur sont marquées par un caractère ':'


-- ============================================================
--   Table : AVIS
-- ============================================================
INSERT INTO avis (id_trajet, auteur, destinataire, note, commentaire) VALUES (:id_trajet, :auteur, :destinataire, :note, :commentaire); -- ajout
DELETE FROM avis WHERE auteur = :auteur AND destinataire = :destinataire AND id_trajet = :id_trajet; -- suppression

-- ============================================================
--   Table : ETAPE
-- ============================================================
INSERT INTO etape (duree, distance, id_trajet, ville_depart, ville_arrivee) VALUES (:duree, :distance, :id_trajet, :ville_depart, :ville_arrivee);
DELETE FROM etudiant WHERE id_etudiant = :id_etudiant;

-- ============================================================
--   Table : ETUDIANT
-- ============================================================
INSERT INTO etudiant (nom_etudiant, prenom_etudiant) VALUES (:nom, :prenom);
DELETE FROM etudiant WHERE id_etudiant = :id_etudiant;

-- ============================================================
--   Table : TRAJET
-- ============================================================
INSERT INTO trajet (instant_depart, frais_par_passager, conducteur, id_voiture) VALUES (:instant_depart, :frais_par_passager, :conducteur, :id_voiture);
DELETE FROM trajet WHERE id_trajet = :id_trajet;

-- ============================================================
--   Table : VILLE
-- ============================================================
INSERT INTO ville (nom_ville) VALUES (:nom_ville);
DELETE FROM etudiant WHERE id_etudiant = :id_etudiant;

-- ============================================================
--   Table : VOITURE
-- ============================================================
INSERT INTO voiture (type, couleur, nombre_de_places, etat, conducteur) VALUES (:type, :couleur, :ndp, :etat, :conducteur);
DELETE FROM voiture WHERE id_voiture = :id_voiture;

-- ============================================================
--   Table : INSCRIPTION
-- ============================================================
INSERT INTO inscription (id_etudiant, id_trajet, id_ville, acceptation) VALUES (:id_etudiant, :id_trajet, :id_ville, false);
UPDATE inscription SET acceptation = TRUE WHERE id_etudiant = :id_etudiant AND id_trajet = :id_trajet AND id_ville = :id_ville;
DELETE FROM inscription WHERE id_etudiant = :id_etudiant AND id_trajet = :id_trajet AND id_ville = :id_ville;