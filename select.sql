-- Informations sur les conducteurs, passagers (pour un etudiant, on obtient les trajets auxquels il a participé, ceux qu'il a proposé)


-- Liste des véhicules disponibles pour un jour donné pour une ville donnée
SELECT vo.*
FROM (((voiture vo INNER JOIN trajet t ON vo.id_conducteur = vo.id_conducteur)
        INNER JOIN etape e ON t.id_trajet = e.id_trajet)
        INNER JOIN ville vi ON e.id_ville_depart = vi.id_ville) -- justifier pourquoi on prend pas les villes d'arrivee (parce que une ville arrivee est forcement une ville depart d'une autre etape, sauf la derniere etape mais ville d'arrivee par importante dans ce cas)
WHERE vi.id_ville = "Bordeaux" AND CAST(FROM_UNIXTIME(colonne_timestamp) as date) = TO_DATE("13-10-1921", "DD-MM-YYYY");

-- Les trajets proposés dans un intervalle de jours donné la liste des villes renseignées entre le campus et une ville donnée

-- Les trajets pouvant desservir une ville donnée dans un intervalle de temps