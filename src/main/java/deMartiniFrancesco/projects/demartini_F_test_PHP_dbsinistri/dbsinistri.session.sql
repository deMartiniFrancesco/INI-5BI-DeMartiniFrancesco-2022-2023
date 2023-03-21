USE dbsinistri;

CREATE TABLE assicurazione (
  codass varchar(30) NOT NULL,
  nome varchar(30) NOT NULL,
  sede varchar(30) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE auto (
  targa varchar(10) NOT NULL,
  marca varchar(30) NOT NULL,
  cilindrata int(11) DEFAULT NULL,
  potenza int(11) DEFAULT NULL,
  codf varchar(16) DEFAULT NULL,
  codass varchar(30) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE autocoinvolta (
  cods varchar(20) NOT NULL,
  targa varchar(10) NOT NULL,
  importodanno int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE proprietario (
  codf varchar(16) NOT NULL,
  nome varchar(50) NOT NULL,
  residenza varchar(50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE sinistro (
  cods varchar(20) NOT NULL,
  localita varchar(50) NOT NULL,
  data date NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE utente (
  username varchar(20) NOT NULL,
  password varchar(60) NOT NULL,
  cognome varchar(30) NOT NULL,
  nome varchar(30) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE assicurazione
ADD PRIMARY KEY (codass);

--
-- Indici per le tabelle auto
--
ALTER TABLE auto
ADD PRIMARY KEY (targa),
  ADD KEY codf (codf),
  ADD KEY codass (codass);

ALTER TABLE autocoinvolta
ADD PRIMARY KEY (cods, targa),
  ADD KEY targa (targa);
--
-- Indici per le tabelle proprietario
--
ALTER TABLE proprietario
ADD PRIMARY KEY (codf);

--
-- Indici per le tabelle sinistro
--
ALTER TABLE sinistro
ADD PRIMARY KEY (cods);
ALTER TABLE utente
ADD PRIMARY KEY (username);
ALTER TABLE auto
ADD CONSTRAINT auto_ibfk_1 FOREIGN KEY (codf) REFERENCES proprietario (codf),
  ADD CONSTRAINT auto_ibfk_2 FOREIGN KEY (codass) REFERENCES assicurazione (codass);
ALTER TABLE autocoinvolta
ADD CONSTRAINT autocoinvolta_ibfk_1 FOREIGN KEY (cods) REFERENCES sinistro (cods),
  ADD CONSTRAINT autocoinvolta_ibfk_2 FOREIGN KEY (targa) REFERENCES auto (targa);