-- Informations sur les conducteurs, passagers (pour un etudiant, on obtient les trajets auxquels il a participé, ceux qu'il a proposé) 

-- Liste des véhicules disponibles pour un jour donné pour une ville donnée
SELECT vo.*
FROM voiture vo
INNER JOIN trajet t ON vo.conducteur = t.conducteur
INNER JOIN etape e ON t.id_trajet = e.id_trajet
INNER JOIN ville vi ON e.ville_depart = vi.id_ville
WHERE vi.nom_ville = 'Bordeaux'
AND DATE_TRUNC('day', t.instant_depart)::DATE = '1921-10-13'
;

-- Les trajets proposés dans un intervalle de jours donné la liste des villes renseignées entre le campus et une ville donnée

-- Les trajets pouvant desservir une ville donnée dans un intervalle de temps
SELECT t.id_trajet, t.instant_depart, v_dep.nom_ville AS ville_depart, v_arr.nom_ville AS ville_arrivee
FROM trajet t
JOIN etape et_dep ON t.id_trajet = et_dep.id_trajet
JOIN etape et_arr ON t.id_trajet = et_arr.id_trajet
JOIN ville v_dep ON et_dep.ville_depart = v_dep.id_ville
JOIN ville v_arr ON et_arr.ville_arrivee = v_arr.id_ville
WHERE (v_dep.nom_ville = 'Bordeaux')
AND t.instant_depart >= '1921-10-10'::TIMESTAMP
AND t.instant_depart <= '1921-10-20'::TIMESTAMP
;
