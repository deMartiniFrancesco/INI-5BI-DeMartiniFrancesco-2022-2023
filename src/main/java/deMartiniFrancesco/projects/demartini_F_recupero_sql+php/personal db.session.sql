DROP TABLE if EXISTS voto;
DROP TABLE if EXISTS brano;
DROP TABLE if EXISTS artista;
DROP TABLE if EXISTS studente;


CREATE TABLE studente (
  matricola varchar(20),
  cognome varchar(30) NOT NULL,
  nome varchar(30) NOT NULL,
  PRIMARY KEY (matricola)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into studente (nome,cognome,matricola) values ('MAXIMO','ALDRIGHETTI','18515');
insert into studente (nome,cognome,matricola) values ('MIRKO','ARDUINI','18906');
insert into studente (nome,cognome,matricola) values ('ENRICO','BONIZZI','18920');
insert into studente (nome,cognome,matricola) values ('MARICA','BRAZZOLI','20055');
insert into studente (nome,cognome,matricola) values ('TOMMASO','BRUNELLI','18927');
insert into studente (nome,cognome,matricola) values ('DAVIDE','CASTELLI','18947');

CREATE TABLE artista (
  id int auto_increment primary key,
  descr varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
insert into artista(id,descr) values(1,'artista1');
insert into artista(id,descr) values(2,'artista2');
insert into artista(id,descr) values(3,'gruppo3');


CREATE TABLE brano(
  id int auto_increment primary key,
  titolo varchar(50) NOT NULL,
  durata int,
  idartista int NOT NULL,
  CONSTRAINT brano_artista_fk1 FOREIGN KEY (idartista) REFERENCES artista(id)
   ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into brano values (1,'brano1_1',NULL,1);
insert into brano values (2,'brano2_1',265,1);
insert into brano values (3,'brano1_2',320,2);
insert into brano values (4,'brano2_2',184,2);
insert into brano values (5,'brano1_3',NULL,3);
insert into brano values (6,'brano3_1',200,1);


CREATE TABLE voto(
  matricola varchar(20),
  idbrano int,
  voto int not null,
  datamod datetime not null DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT voto_1_5 CHECK ((voto >=1 and voto <=5)),
  primary key(matricola,idbrano),
  CONSTRAINT voto_brano_fk1 FOREIGN KEY (idbrano) REFERENCES brano(id)
   ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT voto_studente_fk1 FOREIGN KEY (matricola) REFERENCES studente(matricola)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into voto (matricola,idbrano,voto) values ('18515',1,4);
insert into voto (matricola,idbrano,voto) values ('18515',3,5);
insert into voto (matricola,idbrano,voto) values ('18515',4,5);
insert into voto (matricola,idbrano,voto) values ('18906',2,5);
insert into voto (matricola,idbrano,voto) values ('18906',6,1);
insert into voto (matricola,idbrano,voto) values ('18920',2,3);