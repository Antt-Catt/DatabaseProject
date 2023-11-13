-- Informations sur les conducteurs, passagers

-- Liste des véhicules disponibles pour un jour donné pour une ville donnée
SELECT vo.*
FROM (((voiture vo INNER JOIN trajet t ON vo.id_conducteur = vo.id_conducteur)
        INNER JOIN etape e ON t.id_trajet = e.id_trajet)
        INNER JOIN ville vi ON e.id_ville_depart = vi.id_ville) -- justifier pourquoi on prend pas les villes d'arrivee (parce que une ville arrivee est forcement une ville depart d'une autre etape, sauf la derniere etape mais ville d'arrivee par importante dans ce cas)
WHERE vi.id_ville = "ville" AND t.date = "date";