------------------------------
-- Archivo de base de datos --
------------------------------

/* Tabla usuarios_id, este id de usuario no se eliminará nunca*/
DROP TABLE IF EXISTS usuarios_id CASCADE;

CREATE TABLE usuarios_id
(
    id      BIGSERIAL PRIMARY KEY
);

/* Tabla de usuarios en sí, la que contiene todos los datos de un
    usuario registrado */
DROP TABLE IF EXISTS usuarios
(
      id        bigint          PRIMARY KEY REFERENCES usuarios_id (id)
    , login     varchar(255)    NOT NULL UNIQUE
    , email     varchar(255)    NOT NULL UNIQUE
    , nombre    varchar(255)    NOT NULL
    , apellido  varchar(255)    NOT NULL
    , biografia varchar(255)
    , url_avatar varchar(255)
    , pass      varchar(255)    NOT NULL
    , auth_key  varchar(255)    NOT NULL
    , created_at timestamp(0)   NOT NULL DEFAULT localtimestamp
);
