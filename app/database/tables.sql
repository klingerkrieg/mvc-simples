DROP TABLE IF EXISTS usuarios;

CREATE TABLE IF NOT EXISTS usuarios (
    id              INTEGER PRIMARY KEY,
    nome            TEXT    NOT NULL,
    email           TEXT    NOT NULL,
    senha           TEXT    NOT NULL,
    dataNascimento  TEXT,
    tipo            INTEGER,
    ativado         INTEGER
);

INSERT INTO usuarios (id, nome, email, senha, dataNascimento, tipo, ativado) values (1,'teste 1', 'teste1@gmail.com', '123456', '01-01-2000',1,1);
INSERT INTO usuarios (id, nome, email, senha, dataNascimento, tipo, ativado) values (2,'teste 2', 'teste2@gmail.com', '123456', '01-01-2001',1,1);
INSERT INTO usuarios (id, nome, email, senha, dataNascimento, tipo, ativado) values (3,'teste 3', 'teste3@gmail.com', '123456', '01-01-2003',1,1);
