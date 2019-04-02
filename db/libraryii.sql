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
      id            bigint          PRIMARY KEY REFERENCES usuarios_id (id)
                                        ON DELETE CASCADE
                                        ON UPDATE CASCADE
    , login         varchar(255)    NOT NULL UNIQUE
    , email         varchar(255)    NOT NULL UNIQUE
    , nombre        varchar(255)    NOT NULL
    , apellido      varchar(255)    NOT NULL
    , biografia     varchar(255)
    , url_avatar    varchar(255)
    , pass          varchar(255)    NOT NULL
    , auth_key      varchar(255)
    , created_at    timestamp(0)   NOT NULL DEFAULT localtimestamp
    , updated_at    timestamp(0)
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
      id            BIGSERIAL PRIMARY KEY
    , nombre        varchar(255) NOT NULL
    , descripcion   varchar(255) NOT NULL
    , anyo          numeric(4) NOT NULL
);

/* Tabla Libros */
DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros
(
      id            BIGSERIAL PRIMARY KEY
    , titulo        varchar(255) NOT NULL
    , isbn          varchar(255) NOT NULL
    , anyo          numeric(4) NOT NULL
    , sinopsis      varchar(255) NOT NULL
    , url_compra    varchar(255) NOT NULL
    , autor_id      BIGINT REFERENCES autores (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , genero_id     BIGINT REFERENCES generos (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);

/* Tabla comentarios */
DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios
(
      id                BIGSERIAL PRIMARY KEY
    , usuario_id        BIGINT REFERENCES usuarios (id)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
    , libro_id          BIGINT REFERENCES libros (id)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
    , comentario_id     BIGINT REFERENCES comentarios (id)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
);

/* Tabla Posts */
DROP TABLE IF EXISTS posts CASCADE;

CREATE TABLE posts
(
      id            BIGSERIAL PRIMARY KEY
    , contenido     varchar(255) NOT NULL
    , created_at    timestamp(0)   NOT NULL DEFAULT localtimestamp
    , usuario_id    BIGINT REFERENCES usuarios (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);

/* Tabla Libros favoritos */
DROP TABLE IF EXISTS libros_favs CASCADE;

CREATE TABLE libros_favs
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT REFERENCES usuarios (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , libro_id      BIGINT REFERENCES libros (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);

/* Tabla Autores favoritos */
DROP TABLE IF EXISTS autores_favs CASCADE;

CREATE TABLE autores_favs
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT REFERENCES usuarios (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , autor_id      BIGINT REFERENCES autores (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);


------------------------
-------- VALUES --------
------------------------

-- Usuarios_id --
INSERT INTO usuarios_id (id)
VALUES (DEFAULT), (DEFAULT), (DEFAULT), (DEFAULT), (DEFAULT), (DEFAULT),
       (DEFAULT), (DEFAULT);

-- Usuarios --
INSERT INTO usuarios (id, login, email, nombre, apellido, biografia, url_avatar,
    pass, auth_key, created_at, updated_at)
VALUES (1, 'jose', 'jose@jose.com', 'jose', 'gallego', 'Joven programador...',
            '', crypt('jose123', gen_salt('bf',10)), '', , )
    ,  (2, ...)
    ,  (3, ...)
    ,  (4, ...)
    ,  (5, ...)
    ,  (6, ...)
    ,  (7, ...)
    ,  (8, ...)

-- Autores --
INSERT INTO autores (id, nombre, descripcion, anyo)
VALUES ('Stephen King', 'Stephen Edwin King es un escritor estadounidense
            conocido por sus novelas de terror. Los libros ...', 1947)
    ,  ('Carlos Ruiz Zafón', 'Escritor con una temprana vocación, comenzó
            con literatura juvenil con la novela "El principe de la niebla".', 1964)
    ,  ('Isabel Allende', 'Isabel Allende Llona es una reconocida escritora
            y periodista chilena, conocida principalmente por sus novelas ...', 1942)
    ,  ('Georg R. R. Martin', 'George Raymond Richard Martin conocido por sus
            seguidores como GRRM, es un escritor y guionista estadounidense ...', 1948)
    ,  ('Arturo Pérez Reverte', 'Es un periodista y escritor español, miembro
            de la Real Academia Española. Antiguo corresponsal de Radio...', 1951)
    ,  ('Megan Maxwell', 'Megan Maxwell es una conocida escritora de literatura
            romántica de origen español, por parte de madre y norteamericano,...', 1965);

-- Generos --
INSERT INTO generos ( genero)
VALUES ('Artes', 'Aventuras', 'Biografías y Memorias', 'Ciencia-Ficción'
        , 'Ciencias y Naturaleza', 'Clásicos', 'Erótica', 'Fantasía', 'Histórica y Bélica'
        , 'Humor', 'Infantil', 'Informática y Tecnología', 'Literatura', 'Narrativa'
        , 'Poesía', 'Romántica', 'Superhéroes', 'Teatro');

-- Generos --
INSERT INTO generos ( genero)
VALUES ('Artes', 'Aventuras', 'Biografías y Memorias', 'Ciencia-Ficción'
        , 'Ciencias y Naturaleza', 'Clásicos', 'Erótica', 'Fantasía', 'Histórica y Bélica'
        , 'Humor', 'Infantil', 'Informática y Tecnología', 'Literatura', 'Narrativa'
        , 'Poesía', 'Romántica', 'Superhéroes', 'Teatro');

-- Libros --
INSERT INTO libros ( titulo, isbn, anyo, sinopsis, url_compra, autor_id, genero_id)
VALUES ();
