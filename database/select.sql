-- Informations sur les conducteurs, passagers (pour un etudiant, on obtient les trajets auxquels il a participe, ceux qu'il a proposé)

SELECT 'Conducteur' AS role, DATE(t.instant_depart) as date_depart, vd.nom_ville AS ville_depart, va.nom_ville AS ville_arrivee, t.frais_par_passager
FROM  trajet t
JOIN etape e ON t.id_trajet = e.id_trajet
JOIN ville vd ON e.ville_depart = vd.id_ville
JOIN ville va ON e.ville_arrivee = va.id_ville
WHERE t.conducteur = 1

UNION

SELECT 'Passager' AS role, DATE(t.instant_depart) as date_depart, vd.nom_ville AS ville_depart, va.nom_ville AS ville_arrivee, t.frais_par_passager
FROM trajet t
JOIN inscription i ON t.id_trajet = i.id_trajet
JOIN etape e ON t.id_trajet = e.id_trajet
JOIN ville vd ON e.ville_depart = vd.id_ville
JOIN ville va ON e.ville_arrivee = va.id_ville
WHERE i.id_etudiant = 1
;

-- Liste des vehicules disponibles pour un jour donne pour une ville donnee
SELECT vo.*
FROM voiture vo
INNER JOIN trajet t ON vo.id_voiture = t.id_voiture
INNER JOIN etape e ON t.id_trajet = e.id_trajet
INNER JOIN ville vi ON e.ville_depart = vi.id_ville
WHERE vi.nom_ville = 'BORDEAUX'
AND DATE_TRUNC('day', t.instant_depart)::DATE = '1921-10-13'
;

-- Les trajets proposes dans un intervalle de jours donne la liste des villes renseignees entre le campus et une ville donnee
SELECT t.*, e.ville_depart, e.ville_arrivee
FROM trajet
INNER JOIN etape e ON t.id_trajet = e.id_trajet
WHERE t.instant_depart BETWEEN :date_debut AND :date_fin;

SELECT e.ville_depart
FROM (SELECT DISTINCT t.id_trajet AS id_trajet
FROM trajet t
INNER JOIN etape e1 ON t.id_trajet = e1.id_trajet
INNER JOIN etape e2 ON t.id_trajet = e2.id_trajet
WHERE e1.ville_depart = 'CAMPUS'
AND e2.ville_arrivee = ':VILLE_DONNEE';)
INNER JOIN etape e ON id_trajet = e.id_trajet
WHERE e.ville_depart != 'CAMPUS';



-- Les trajets pouvant desservir une ville donnée dans un intervalle de temps
SELECT t.id_trajet, t.instant_depart, v_dep.nom_ville AS ville_depart, v_arr.nom_ville AS ville_arrivee
FROM trajet t
INNER JOIN etape et_dep ON t.id_trajet = et_dep.id_trajet
INNER JOIN etape et_arr ON t.id_trajet = et_arr.id_trajet
INNER JOIN ville v_dep ON et_dep.ville_depart = v_dep.id_ville
INNER JOIN ville v_arr ON et_arr.ville_arrivee = v_arr.id_ville
WHERE (v_dep.nom_ville = 'BORDEAUX')
AND DATE_TRUNC('day', t.instant_depart)::DATE >= '1921-10-10'
AND DATE_TRUNC('day', t.instant_depart)::DATE <= '1921-10-20'
;

-- Moyenne des passagers sur l’ensemble des trajets effectues
SELECT AVG(nb_passagers) AS moyenne_passagers
FROM (
    SELECT t.id_trajet, COUNT(i.id_etudiant) AS nb_passagers
    FROM trajet t
    LEFT JOIN inscription i ON t.id_trajet = i.id_trajet
    GROUP BY t.id_trajet
) AS passagers_par_trajet;

-- Moyenne des distances parcourues en covoiturage par jour
SELECT DATE(t.instant_depart) AS jour, AVG(e.distance) AS moyenne_distances_par_jour
FROM trajet t
JOIN etape e ON t.id_trajet = e.id_trajet
GROUP BY DATE(t.instant_depart);

-- Classement des meilleurs conducteurs d’apres les avis
SELECT e.nom_etudiant || ' ' || e.prenom_etudiant AS conducteur, AVG(a.note) AS moyenne_avis
FROM etudiant e
JOIN trajet t ON e.id_etudiant = t.conducteur
LEFT JOIN avis a ON t.id_trajet = a.id_trajet
WHERE a.destinataire = e.id_etudiant
GROUP BY e.id_etudiant
ORDER BY moyenne_avis DESC;

-- Classement des meilleurs passagers d’apres les avis
SELECT e.nom_etudiant || ' ' || e.prenom_etudiant AS passager, AVG(a.note) AS moyenne_avis
FROM etudiant e
JOIN inscription i ON e.id_etudiant = i.id_etudiant
LEFT JOIN avis a ON i.id_trajet = a.id_trajet
WHERE a.destinataire = e.id_etudiant
GROUP BY e.id_etudiant
ORDER BY moyenne_avis DESC;

-- Classement des villes selon le nombre de trajets qui les dessert
SELECT v.nom_ville, COUNT(DISTINCT t.id_trajet) AS nombre_trajets
FROM ville v
JOIN etape e ON v.id_ville = e.ville_depart OR v.id_ville = e.ville_arrivee
JOIN trajet t ON e.id_trajet = t.id_trajet
GROUP BY v.nom_ville
ORDER BY nombre_trajets DESC;

-- Avis renseignés par un étudiant (auteur) à un autre (destinataire) pour un trajet partagé
SELECT a.*, CONCAT(au.nom_etudiant, ' ', au.prenom_etudiant) as auteur, CONCAT(de.nom_etudiant, ' ', de.prenom_etudiant) as destinataire
                  FROM avis a
                  INNER JOIN etudiant au ON a.auteur = au.id_etudiant
                  INNER JOIN etudiant de ON a.destinataire = de.id_etudiant
                  WHERE 1=1;

-- Selection des type, couleur, nom et prénom du conducteur des voitures
SELECT vo.type, vo.couleur, et.nom_etudiant, et.prenom_etudiant
                  FROM voiture vo
                  INNER JOIN etudiant et ON vo.conducteur = et.id_etudiant
                  WHERE 1 = 1;

-- Selectionne le nom et prénom d'un étudiant à partir d'une recherche sur son nom et prénom
SELECT * FROM etudiant WHERE LOWER(nom_etudiant) LIKE '%$filter%' OR LOWER(prenom_etudiant) LIKE '%$filter%';

-- Selectionne pour chaque trajet le type le nom et prénom du conducteur, les frais par passager pour le trajet, la date et l'heure du départ, les ville de départ et d'arrivée et la durée du trajet
SELECT vo.type, et.nom_etudiant, et.prenom_etudiant, t.frais_par_passager, t.instant_depart, vi_depart.nom_ville AS nom_ville_depart, vi_arrivee.nom_ville AS nom_ville_arrivee, e.duree
                  FROM voiture vo
                  INNER JOIN trajet t ON vo.id_voiture = t.id_voiture
                  INNER JOIN etape e ON t.id_trajet = e.id_trajet
                  INNER JOIN ville vi_depart ON e.ville_depart = vi_depart.id_ville
                  INNER JOIN ville vi_arrivee ON e.ville_arrivee = vi_arrivee.id_ville
                  INNER JOIN etudiant et ON vo.conducteur = et.id_etudiant
                  WHERE 1 = 1;

-- Selectionne dans la table ville, la ville si elle existe que l'utilisateur aura renseigné dans un formulaire
SELECT id_ville FROM ville WHERE nom_ville = :nom_ville;
