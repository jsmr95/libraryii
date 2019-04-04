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
(   id              BIGSERIAL PRIMARY KEY
    ,  usuario_id   bigint REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , login         varchar(255)    NOT NULL UNIQUE
    , email         varchar(255)    NOT NULL UNIQUE
    , nombre        varchar(255)    NOT NULL
    , apellido      varchar(255)    NOT NULL
    , biografia     varchar(255)
    , url_avatar    varchar(255)
    , password      varchar(255)    NOT NULL
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

/* Tabla Usuarios favoritos */
DROP TABLE IF EXISTS users_favs CASCADE;

CREATE TABLE users_favs
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT REFERENCES usuarios (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , usuario_fav      BIGINT REFERENCES usuarios (id)
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
INSERT INTO usuarios (usuario_id, login, email, nombre, apellido, biografia, url_avatar, password)
VALUES (1, 'jose', 'jose@jose.com', 'Jose', 'Gallego', 'Joven programador...',
            null, 'jose')
    ,  (2, 'pepe', 'pepe@pepe.com', 'Pepe', 'Ruiz', 'Programador senior...',
            null, crypt('pepe', gen_salt('bf',10)))
    ,  (3, 'admin', 'admin@admin.com', 'admin', 'admin', 'Un administrador...',
            null, crypt('admin', gen_salt('bf',10)))
    ,  (4, 'carmen', 'carmen@carmen.com', 'Carmen', 'Gallego', 'Joven programadora...',
            null, crypt('carmen', gen_salt('bf',10)));

-- Autores --
INSERT INTO autores (nombre, descripcion)
VALUES ('Stephen King', 'Stephen Edwin King es un escritor estadounidense
            conocido por sus novelas de terror. Los libros ...')
    ,  ('Carlos Ruiz Zafón', 'Escritor con una temprana vocación, comenzó
            con literatura juvenil con la novela "El principe de la niebla".')
    ,  ('Isabel Allende', 'Isabel Allende Llona es una reconocida escritora
            y periodista chilena, conocida principalmente por sus novelas ...')
    ,  ('Georg R. R. Martin', 'George Raymond Richard Martin conocido por sus
            seguidores como GRRM, es un escritor y guionista estadounidense ...')
    ,  ('Arturo Pérez Reverte', 'Es un periodista y escritor español, miembro
            de la Real Academia Española. Antiguo corresponsal de Radio...')
    ,  ('Megan Maxwell', 'Megan Maxwell es una conocida escritora de literatura
            romántica de origen español, por parte de madre y norteamericano,...')
    ,  ('Antoine de Saint Exupéry', 'Antoine de Saint-Exupéry(Lyon-Marsella) fue
            un escritor y aviador francés, autor de "El principito"');

-- Generos --
INSERT INTO generos ( genero)
VALUES ('Artes')
        , ('Aventuras')
        , ('Biografías y Memorias')
        , ('Ciencia-Ficción')
        , ('Ciencias y Naturaleza')
        , ('Clásicos')
        , ('Erótica')
        , ('Fantasía')
        , ('Histórica y Bélica')
        , ('Humor')
        , ('Infantil')
        , ('Informática y Tecnología')
        , ('Literatura')
        , ('Narrativa')
        , ('Poesía')
        , ('Romántica')
        , ('Superhéroes')
        , ('Teatro')
        , ('Novela')
        , ('Juvenil no ficción');

-- Libros --
INSERT INTO libros ( titulo, isbn, anyo, sinopsis, url_compra, autor_id, genero_id)
VALUES ('El principito', '9788498381498', 1943, 'El principito habita un pequeñísimo
            asteroide, que comparte con una flor y empieza a experimentar la soledad.'
            , 'https://www.amazon.es/gp/product/8498381495/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 7, 13)
    ,  ('El resplandor', '9789875668478', 1977, 'Tenía una deuda pendiente con Stephen King.
            Crecí rodeado de sus libros;It, Cementerio de animales, ...'
            , 'https://www.amazon.es/gp/product/9875668478/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 1, 19)
    ,  ('Marina', '9788423687268', 1999, 'Óscar Drai se marchó huyendo de sus recuerdos, pensando ingenuamente que,
            si ponía suficiente distancia, las voces de su pasado se acallarían para siempre ...'
            , 'https://www.amazon.es/gp/product/8423687260/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 2, 20)
    ,  ('La suma de los días', '9788401341915', 2007, 'Isabel Allende narra a su hija Paula
            todo lo que ha sucedido con la familia desde el momento en que ella murió. El lector vive, junto con la autora...'
            , 'https://www.amazon.es/gp/product/8401341914/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 3, 3)
    ,  ('Juego de tronos (canción de hielo y fuego #1)', '9788496208964', 1996, 'Primer libro de la saga CANCIÓN DE HIELO Y FUEGO.
            «En un mundo donde las estaciones pueden durar decenios y donde las tierras del norte,
            más allá del Muro, ocultan seres míticos y temibles,...'
            , 'https://www.amazon.es/gp/product/8496208966/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 4, 8)
    ,  ('Las ranas también se enamoran', '9788492929467', 2011, 'Marta Rodríguez es una joven y divertida madre
              soltera que conduce una Honda CBF 600. Trabaja en el taller de moda flamenca de Lola Herrera,...'
            , 'https://www.amazon.es/gp/product/8492929464/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 6, 13);

-- Comentarios --
INSERT INTO comentarios (usuario_id, libro_id, comentario_id)
VALUES  (1,1,null)
        ,  (1, 2, null)
        ,  (2, 3, null)
        ,  (3, 4, null);

-- Libros_favs --
INSERT INTO libros_favs (usuario_id, libro_id)
VALUES  (1,1)
        ,  (1, 2)
        ,  (2, 2)
        ,  (3, 2);

-- Autores_favs --
INSERT INTO autores_favs (usuario_id, autor_id)
VALUES  (1,1)
        ,  (1, 1)
        ,  (2, 1)
        ,  (3, 1);

-- Usuarios_favs --
INSERT INTO users_favs (usuario_id, usuario_fav)
VALUES  (1,2)
        ,  (1, 3)
        ,  (2, 3)
        ,  (3, 1);
