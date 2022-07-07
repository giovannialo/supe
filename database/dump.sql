-- --- --- --- --- --- --- --- --- --- ---
-- Banco de dados
-- --- --- --- --- --- --- --- --- --- ---

DROP DATABASE IF EXISTS supe;
CREATE DATABASE IF NOT EXISTS supe
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE supe;


-- --- --- --- --- --- --- --- --- --- ---
-- Configuração
-- --- --- --- --- --- --- --- --- --- ---

# SET FOREIGN_KEY_CHECKS = 0;


-- --- --- --- --- --- --- --- --- --- ---
-- Tabela
-- --- --- --- --- --- --- --- --- --- ---

DROP TABLE IF EXISTS usuario_api;
CREATE TABLE IF NOT EXISTS usuario_api
(
    id            INT         NOT NULL AUTO_INCREMENT,
    nome          VARCHAR(30) NOT NULL,
    senha         VARCHAR(60) NOT NULL,
    hash          VARCHAR(60) NOT NULL,
    criado_em     TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP   NULL ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE (nome),
    UNIQUE (hash)
) ENGINE = InnoDB
  DEFAULT CHARSET utf8mb4;


-- --- --- --- --- --- --- --- --- --- ---
-- Insere dados
-- --- --- --- --- --- --- --- --- --- ---

INSERT INTO usuario_api (nome, senha, hash)
VALUES ('nome', 'senha', 'hash');