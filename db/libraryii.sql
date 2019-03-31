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
DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
      id        bigint          PRIMARY KEY REFERENCES usuarios_id (id) ON DELETE CASCADE ON UPDATE CASCADE
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

/* Tabla Generos */
DROP TABLE IF EXISTS generos CASCADE;

CREATE TABLE generos
(
      id        BIGSERIAL PRIMARY KEY
    , genero    varchar(255) NOT NULL
);

/* Tabla autores */
DROP TABLE IF EXISTS autores CASCADE;

CREATE TABLE autores
(
      id        BIGSERIAL PRIMARY KEY
    , nombre    varchar(255) NOT NULL
    , descripcion    varchar(255) NOT NULL
    , anyo      numeric(4) NOT NULL
);

/* Tabla Libros */
DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros
(
      id        BIGSERIAL PRIMARY KEY
    , titulo    varchar(255) NOT NULL
    , isbn      varchar(255) NOT NULL
    , anyo      numeric(4) NOT NULL
    , sinopsis  varchar(255) NOT NULL
    , url_compra varchar(255) NOT NULL
    , autor_id  BIGINT REFERENCES autores (id) ON DELETE CASCADE ON UPDATE CASCADE
    , genero_id BIGINT REFERENCES generos (id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Tabla comentarios */
DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios
(
      id        BIGSERIAL PRIMARY KEY
    , usuario_id  BIGINT REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
    , libro_id  BIGINT REFERENCES libros (id) ON DELETE CASCADE ON UPDATE CASCADE
    , comentario_id  BIGINT REFERENCES comentarios (id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Tabla Posts */
DROP TABLE IF EXISTS posts CASCADE;

CREATE TABLE posts
(
      id        BIGSERIAL PRIMARY KEY
    , contenido varchar(255) NOT NULL
    , created_at timestamp(0)   NOT NULL DEFAULT localtimestamp
    , usuario_id  BIGINT REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Tabla Libros favoritos */
DROP TABLE IF EXISTS libros_favs CASCADE;

CREATE TABLE libros_favs
(
      id        BIGSERIAL PRIMARY KEY
    , usuario_id  BIGINT REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
    , libro_id  BIGINT REFERENCES libros (id) ON DELETE CASCADE ON UPDATE CASCADE
);

/* Tabla Autores favoritos */
DROP TABLE IF EXISTS autores_favs CASCADE;

CREATE TABLE autores_favs
(
      id        BIGSERIAL PRIMARY KEY
    , usuario_id  BIGINT REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
    , autor_id  BIGINT REFERENCES autores (id) ON DELETE CASCADE ON UPDATE CASCADE
);


------------------------
-------- VALUES --------
------------------------
