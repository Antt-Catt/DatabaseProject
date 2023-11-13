-- ============================================================
--   Nom de la base   :  COVOITURAGE                                
--   Nom de SGBD      :  PostgreSQL                   
--   Date de creation :  12/11/2023                       
-- ============================================================

DROP TABLE etudiant;

DROP TABLE voiture;

DROP TABLE ville;

DROP TABLE etape;

DROP TABLE trajet;

-- ============================================================
--   Table : ETUDIANT                                            
-- ============================================================
CREATE TABLE etudiant
(
    id_etudiant                     SERIAL                 NOT NULL,
    nom_etudiant                    VARCHAR(20)            NOT NULL,
    prenom_etudiant                 VARCHAR(20)                    ,

    -- nation_acteur                   VARCHAR(20)                    ,
    -- date_de_naissance               DATE                           ,
    CONSTRAINT pk_etudiant PRIMARY KEY (id_etudiant)
);

-- ============================================================
--   Table : VOITURE                                       
-- ============================================================
CREATE TABLE voiture
(
    id_voiture                      SERIAL                    NOT NULL,
    type                            VARCHAR(20)               NOT NULL,
    couleur                         VARCHAR(20)                       ,
    nombre_de_place                 INTEGER                           ,
    -- passagers
    etat                            VARCHAR(20)                       ,
    CONSTRAINT pk_voiture PRIMARY KEY (id_voiture)
);

-- ============================================================
--   Table : VILLE                                              
-- ============================================================
CREATE TABLE ville
(
    id_ville                        SERIAL                 NOT NULL,
    CONSTRAINT pk_ville PRIMARY KEY (id_ville)
);

-- ============================================================
--   Table : ETAPE                                              
-- ============================================================
CREATE TABLE etape
(
    id_etape                        SERIAL                 NOT NULL,
    duree                           INTEGER                NOT NULL,
    distance                        INTEGER                        ,
    CONSTRAINT pk_etape PRIMARY KEY (id_etape)
);

-- ============================================================
--   Table : TRAJET                                              
-- ============================================================
CREATE TABLE trajet
(
    id_trajet                       SERIAL                 NOT NULL,
    date                            DATE                           ,
    heure_depart                    INTEGER                NOT NULL,
    frais_par_passager              INTEGER                NOT NULL,
    CONSTRAINT pk_trajet PRIMARY KEY (numero_trajet)
);

ALTER TABLE film
    ADD CONSTRAINT fk1_film FOREIGN KEY (numero_realisateur)
       REFERENCES realisateur (numero_realisateur);

ALTER TABLE role
    ADD CONSTRAINT fk1_role FOREIGN KEY (numero_acteur)
       REFERENCES acteur (numero_acteur);

ALTER TABLE role
    ADD CONSTRAINT fk2_role FOREIGN KEY (numero_film)
       REFERENCES film (numero_film);

