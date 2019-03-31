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

CREATE TABLE usuarios
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
    , updated_at timestamp(0)
);

/* Tabla Libros */
DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros
(
      id        BIGSERIAL PRIMARY KEY
    , titulo    varchar(255) NOT NULL
    , isbn      varchar(255) NOT NULL
    , sinopsis  varchar(255) NOT NULL
    , url_compra varchar(255) NOT NULL
    , anyo      numeric(4) NOT NULL
    , autor_id  varchar(255) PRIMARY KEY REFERENCES autor (id)
    , genero_id varchar(255) PRIMARY KEY REFERENCES genero (id)
);
