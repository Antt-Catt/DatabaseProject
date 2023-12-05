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