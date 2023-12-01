-- ============================================================
--   Nom de la base   :  COVOITURAGE                                
--   Nom de SGBD      :  PostgreSQL                   
--   Date de creation :  12/11/2023                       
-- ============================================================




DROP TABLE IF EXISTS etape;

DROP TABLE IF EXISTS inscription;

DROP TABLE IF EXISTS ville;

DROP TABLE IF EXISTS trajet;

DROP TABLE IF EXISTS avis;

DROP TABLE IF EXISTS voiture;

DROP TABLE IF EXISTS etudiant;


-- ============================================================
--   Table : ETUDIANT                                            
-- ============================================================
CREATE TABLE etudiant
(
    id_etudiant                     SERIAL                 NOT NULL,
    nom_etudiant                    VARCHAR(20)            NOT NULL,
    prenom_etudiant                 VARCHAR(20)                    ,

    CONSTRAINT pk_etudiant PRIMARY KEY (id_etudiant)
);

-- ============================================================
--   Table : AVIS                                            
-- ============================================================
CREATE TABLE avis
(
    id_trajet                       INTEGER                 NOT NULL,
    auteur INTEGER REFERENCES etudiant(id_etudiant),
    destinataire INTEGER REFERENCES etudiant(id_etudiant),
    note                            INTEGER                        ,
    commentaire                     VARCHAR(20)                     ,
    CONSTRAINT pk_avis PRIMARY KEY (auteur,destinataire,id_trajet)
);


-- ============================================================
--   Table : VOITURE                                       
-- ============================================================
CREATE TABLE voiture
(
    id_voiture                      SERIAL                    NOT NULL,
    type                            VARCHAR(20)                       ,
    couleur                         VARCHAR(20)                       ,
    nombre_de_places                INTEGER                           ,
    etat                            VARCHAR(20)                       ,
    conducteur INTEGER REFERENCES etudiant(id_etudiant),

    CONSTRAINT pk_voiture PRIMARY KEY (id_voiture)
);

-- ============================================================
--   Table : VILLE                                              
-- ============================================================
CREATE TABLE ville
(
    id_ville                        SERIAL                 NOT NULL,
    nom_ville                       VARCHAR(20)            NOT NULL,
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
    id_trajet                       INTEGER                NOT NULL,
    ville_depart INTEGER REFERENCES ville(id_ville),
    ville_arrivee INTEGER REFERENCES ville(id_ville),

    CONSTRAINT pk_etape PRIMARY KEY (id_etape)
);

-- ============================================================
--   Table : TRAJET                                              
-- ============================================================
CREATE TABLE trajet
(
    id_trajet                       SERIAL                 NOT NULL,
    instant_depart                  TIMESTAMP                      ,
    frais_par_passager              INTEGER                NOT NULL,
    conducteur INTEGER REFERENCES etudiant(id_etudiant),
    id_voiture                      INTEGER                NOT NULL,
    
    CONSTRAINT pk_trajet PRIMARY KEY (id_trajet)
);

-- ============================================================
--   Table : INSCRIPTION                                              
-- ============================================================
CREATE TABLE inscription
(
    id_etudiant                     INTEGER                NOT NULL,
    id_trajet                       INTEGER                NOT NULL,
    id_ville                        INTEGER                ,
        
    CONSTRAINT pk_inscription PRIMARY KEY (id_etudiant,id_trajet)
);

ALTER TABLE avis
    ADD CONSTRAINT fk1_avis FOREIGN KEY (auteur)
       REFERENCES etudiant (id_etudiant);

ALTER TABLE avis
    ADD CONSTRAINT fk2_avis FOREIGN KEY (destinataire)
       REFERENCES etudiant (id_etudiant);

ALTER TABLE trajet
    ADD CONSTRAINT fk1_trajet FOREIGN KEY (conducteur)
       REFERENCES etudiant (id_etudiant);

ALTER TABLE trajet
    ADD CONSTRAINT fk2_trajet FOREIGN KEY (id_voiture)
       REFERENCES voiture (id_voiture);

ALTER TABLE etape
    ADD CONSTRAINT fk1_etape FOREIGN KEY (id_trajet)
       REFERENCES trajet (id_trajet);

ALTER TABLE etape
    ADD CONSTRAINT fk2_etape FOREIGN KEY (ville_depart)
       REFERENCES ville (id_ville);

ALTER TABLE etape
    ADD CONSTRAINT fk3_etape FOREIGN KEY (ville_arrivee)
       REFERENCES ville (id_ville);

ALTER TABLE inscription
    ADD CONSTRAINT fk1_inscription FOREIGN KEY (id_etudiant)
       REFERENCES etudiant (id_etudiant);

ALTER TABLE inscription
    ADD CONSTRAINT fk2_inscription FOREIGN KEY (id_trajet)
       REFERENCES trajet (id_trajet);

ALTER TABLE inscription
    ADD CONSTRAINT fk3_inscription FOREIGN KEY (id_ville)
       REFERENCES ville (id_ville);

ALTER TABLE voiture
    ADD CONSTRAINT fk1_voiture FOREIGN KEY (conducteur)
       REFERENCES etudiant (id_etudiant);


