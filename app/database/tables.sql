DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS usuarios (
    id              INTEGER PRIMARY KEY,
    nome            TEXT    NOT NULL,
    dataNascimento  TEXT,
    tipo            INTEGER,
    ativado         INTEGER
);

INSERT INTO usuarios (id, nome, dataNascimento, tipo, ativado) values (1,'teste','01-01-2000',1,1);
INSERT INTO usuarios (id, nome, dataNascimento, tipo, ativado) values (2,'teste 2','01-01-2001',1,1);
INSERT INTO usuarios (id, nome, dataNascimento, tipo, ativado) values (3,'teste 3','01-01-2003',1,1);



/** essa tabela deve ser criada antes de veiculos, 
pois veiculos depende dela 
exemplo de relacionamento UM para MUITOS MODELO x VEICULOS  */
DROP TABLE IF EXISTS modelos;
CREATE TABLE IF NOT EXISTS modelos (
    id              INTEGER PRIMARY KEY,
    modelo           TEXT    NOT NULL
);

INSERT INTO modelos (id, modelo) values (1,'Gol');
INSERT INTO modelos (id, modelo) values (2,'Uno');
INSERT INTO modelos (id, modelo) values (3,'Celta');



DROP TABLE IF EXISTS veiculos;
CREATE TABLE IF NOT EXISTS veiculos (
    id              INTEGER PRIMARY KEY,
    placa           TEXT    NOT NULL,
    modelo_id       INTEGER,
    cor             INTEGER,
    ano             INTEGER,
    /* definicao de chave estrangeira */
    FOREIGN KEY (modelo_id)
       REFERENCES modelos (id)
);



/** essa tabela deve ser criada depois de veiculos e usuarios, 
exemplo de relacionamento MUITOS para MUITOS USUARIOS x VEICULOS */

DROP TABLE IF EXISTS motoristas;
CREATE TABLE IF NOT EXISTS motoristas (
    id      INTEGER PRIMARY KEY,
    usuario_id      TEXT    NOT NULL,
    veiculo_id      TEXT    NOT NULL,
    /* definicao de chave estrangeira */
    FOREIGN KEY (usuario_id)
       REFERENCES usuarios (id),
    FOREIGN KEY (veiculo_id)
       REFERENCES veiculos (id)
);
