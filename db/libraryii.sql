------------------------------
-- Archivo de base de datos --
------------------------------
CREATE EXTENSION pgcrypto;

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
      id            bigint PRIMARY KEY REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
    , login         varchar(255)    NOT NULL UNIQUE
    , email         varchar(255)    NOT NULL UNIQUE
    , nombre        varchar(255)    NOT NULL
    , apellido      varchar(255)    NOT NULL
    , biografia     varchar(255)
    , url_avatar    varchar(255)
    , password      varchar(255)    NOT NULL
    , auth_key      varchar(255)
    , created_at    TIMESTAMP(0)   NOT NULL DEFAULT LOCALTIMESTAMP
    , updated_at    TIMESTAMP(0)
    , banned_at    TIMESTAMP(0)
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
    , descripcion   varchar(800) NOT NULL
    , imagen        varchar(255)
);

/* Tabla Libros */
DROP TABLE IF EXISTS libros CASCADE;

CREATE TABLE libros
(
      id            BIGSERIAL PRIMARY KEY
    , titulo        varchar(255) NOT NULL
    , isbn          varchar(255) NOT NULL UNIQUE
    , imagen        varchar(255)
    , anyo          numeric(4) NOT NULL
    , sinopsis      varchar(800) NOT NULL
    , url_compra    varchar(255) NOT NULL
    , autor_id      BIGINT REFERENCES autores (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , genero_id     BIGINT REFERENCES generos (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , created_at    TIMESTAMP(0) NOT NULL DEFAULT LOCALTIMESTAMP
);

/* Tabla comentarios */
DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios
(
      id                BIGSERIAL PRIMARY KEY
    , texto         TEXT      NOT NULL
    , usuario_id        BIGINT REFERENCES usuarios_id (id)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
    , libro_id          BIGINT REFERENCES libros (id)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
    , comentario_id     BIGINT REFERENCES comentarios (id)
                            ON DELETE CASCADE
                            ON UPDATE CASCADE
    , created_at    TIMESTAMP(0) NOT NULL DEFAULT LOCALTIMESTAMP
);

/* Tabla Posts */
DROP TABLE IF EXISTS estado_personal CASCADE;

CREATE TABLE estado_personal
(
      id            BIGSERIAL PRIMARY KEY
    , contenido     varchar(255) NOT NULL
    , created_at    timestamp(0)   NOT NULL DEFAULT localtimestamp
    , usuario_id    BIGINT REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);

/* Tabla Libros favoritos */
DROP TABLE IF EXISTS libros_favs CASCADE;

CREATE TABLE libros_favs
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT REFERENCES usuarios_id (id)
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
    , usuario_id    BIGINT REFERENCES usuarios_id (id)
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
    , usuario_id    BIGINT REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , usuario_fav      BIGINT REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);

/* Tabla Estados */
DROP TABLE IF EXISTS estados CASCADE;

CREATE TABLE estados
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , estado        varchar(255) NOT NULL
    , created_at    TIMESTAMP(0)   NOT NULL DEFAULT LOCALTIMESTAMP
    , libro_id    BIGINT REFERENCES libros (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);

/* Tabla Estados_Favs */
DROP TABLE IF EXISTS estados_favs CASCADE;

CREATE TABLE estados_favs
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , estado_id     BIGINT REFERENCES estados (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);

/* Tabla Estado_lyb */
DROP TABLE IF EXISTS estados_lyb CASCADE;

CREATE TABLE estados_lyb
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , estado_id     BIGINT REFERENCES estados (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);

/* Tabla votos */
DROP TABLE IF EXISTS votos CASCADE;

CREATE TABLE votos
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , libro_id     BIGINT REFERENCES libros (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , voto          NUMERIC (1,0)
);

/* Tabla libros_estados */
DROP TABLE IF EXISTS libros_estados CASCADE;

CREATE TABLE libros_estados
(
      id            BIGSERIAL PRIMARY KEY
    , estado        VARCHAR(255) NOT NULL
);

/* Tabla seguimientos */
DROP TABLE IF EXISTS seguimientos CASCADE;

CREATE TABLE seguimientos
(
      id            BIGSERIAL PRIMARY KEY
    , usuario_id    BIGINT REFERENCES usuarios_id (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , libro_id     BIGINT REFERENCES libros (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
    , estado_id     BIGINT REFERENCES libros_estados (id)
                        ON DELETE CASCADE
                        ON UPDATE CASCADE
);

------------------------
-------- VALUES --------
------------------------

-- Usuarios_id --
INSERT INTO usuarios_id (id)
VALUES (DEFAULT), (DEFAULT), (DEFAULT), (DEFAULT), (DEFAULT), (DEFAULT),
       (DEFAULT), (DEFAULT) ,(DEFAULT), (DEFAULT), (DEFAULT), (DEFAULT),
       (DEFAULT), (DEFAULT), (DEFAULT);

-- Usuarios --
INSERT INTO usuarios (id, login, email, nombre, apellido, biografia, url_avatar, password, auth_key)
VALUES (1, 'jose', 'jose@jose.com', 'Jose', 'Gallego', 'Joven programador...',
            'user1.jpg', crypt('jose', gen_salt('bf',10)),'')
    ,  (2, 'pepe', 'pepe@pepe.com', 'Pepe', 'Ruiz', 'Programador senior...',
            'user2.jpg', crypt('pepe', gen_salt('bf',10)),'')
    ,  (3, 'admin', 'admin@admin.com', 'admin', 'admin', 'Un administrador...',
            'user3.jpg', crypt('admin', gen_salt('bf',10)),'')
    ,  (4, 'carmen', 'carmen@carmen.com', 'Carmen', 'Gallego', 'Joven programadora...',
            'user4.jpg', crypt('carmen', gen_salt('bf',10)),'')
    ,  (5, 'juan', 'juan@juan.com', 'Juan', 'Del Olmo', 'Me gusta la lectura',
            'user5.jpg', crypt('juan', gen_salt('bf',10)),'')
    ,  (6, 'jesus', 'jesus@jesus.com', 'Jesus', 'Benitez', 'Un jesusistrador...',
            'user6.jpg', crypt('jesus', gen_salt('bf',10)),'')
    ,  (7, 'manuel', 'manuel@manuel.com', 'Manuel', 'Benitez', 'Joven futbolista que le gusta los libros!',
            'user7.jpg', crypt('manuel', gen_salt('bf',10)),'')
    ,  (8, 'david', 'david@david.com', 'David', 'Ramos', 'Un busca vida',
            'user8.jpg', crypt('david', gen_salt('bf',10)),'')
    ,  (9, 'miguel', 'miguel@miguel.com', 'Miguel', 'Sanchez', 'No se como he llegado aqui',
            'user9.jpg', crypt('miguel', gen_salt('bf',10)),'')
    ,  (10, 'sheila', 'sheila@sheila.com', 'Sheila', 'Establiet', 'Estudiantes de psicologia',
            'user10.jpg', crypt('sheila', gen_salt('bf',10)),'')
    ,  (11, 'andrea', 'andrea@andrea.com', 'Andrea', 'Ruiz', 'Alemana, trabajadora y humilde.',
            'user11.jpg', crypt('andrea', gen_salt('bf',10)),'')
    ,  (12, 'leticia', 'leticia@leticia.com', 'Leticia', 'Pepa', 'Animadora en mi tiempo libre.',
            'user12.jpg', crypt('leticia', gen_salt('bf',10)),'')
    ,  (13, 'silvia', 'silvia@silvia.com', 'Silvia', 'Perez', 'Trabajo en AtSistemas.',
            'user13.jpg', crypt('silvia', gen_salt('bf',10)),'')
    ,  (14, 'rafa', 'rafa@rafa.com', 'Rafa', 'Fernandez', 'Arquitecto de vocación!',
            'user14.jpg', crypt('rafa', gen_salt('bf',10)),'')
    ,  (15, 'ildefonso', 'ildefonso@ildefonso.com', 'Ildefonso', 'Hernandez', 'Amante del golf y de mi familia',
            'user15.jpg', crypt('ildefonso', gen_salt('bf',10)),'');
-- Autores --
INSERT INTO autores (nombre, descripcion,imagen)
VALUES ('Stephen King', 'Stephen Edwin King (nacido en Portland, Maine, Estados Unidos, 21 de septiembre de 1947) es un escritor
         estadounidense conocido por sus novelas de terror. Los libros de King han estado muy a menudo en las listas de superventas.
         En 2003 recibió el National Book Award por su trayectoria y contribución a las letras americanas, el cual fue otorgado por la National
          Book Foundation. King, además, ha escrito obras que no corresponden al género de terror, incluyendo las novelas Different Seasons,
          El pasillo de la muerte, Los ojos del dragón, Corazones en Atlántida y su autodenominada “magnum opus”,', 'stephenking.jpg')
    ,  ('Carlos Ruiz Zafón', 'Escritor con una temprana vocación, comenzó con literatura juvenil con la novela “ El príncipe de la niebla”. La novela superventas “La Sombra del Viento” consiguió su consagración como escritor. Novela que quedó finalista en el premio Planeta, pero que despues de publicarse ha cosechado infinidad de premios.'
        , 'carlosruizzafon.jpg')
    ,  ('Isabel Allende', 'Isabel Allende Llona (Lima, Perú, 2 de agosto de 1942) es una reconocida escritora y periodista de nacionalidad chilena, conocida principalmente por sus novelas de corte histórico y romántico, algunas de ellas enmarcadas dentro del realismo mágico. Es considerada la escritora viva de lengua castellana más leída del mundo.

Isabel Allende se hace mundialmente conocida con la publicación de su primera novela, “La casa de los espíritus” (1982), la cual se convirtió rápidamente en éxito superventas.'
        ,'isabelallende.jpg')
    ,  ('Georg R. R. Martin', 'George Raymond Richard Martin (Bayonne, Nueva Jersey, EE.UU., 20 de septiembre de 1948), conocido como George R. R. Martin y en ocasiones por sus seguidores como GRRM, es un escritor y guionista estadounidense de literatura fantástica, ciencia ficción y terror, famoso por ser el autor de la novela rio más espectacular jamás escrita “Canción de hielo y fuego”, compuesta por las novelas “Juego de tronos”, “Choque de reyes”, “Tormenta de espadas”, “Festín de cuervos”, “Danza de dragones” y las futuras “Vientos de invierno” y “Sueño de primavera”. Estás novelas están siendo adaptadas para la televisión por la cadena de cable estadounidense HBO bajo el título de “Juego de tronos”.'
        , 'georgerrmartin.jpg')
    ,  ('Arturo Pérez Reverte', 'Arturo Pérez-Reverte (Cartagena, 25 de noviembre de 1951) es un periodista y escritor español, miembro de la Real Academia Española. Antiguo corresponsal de Radio Televisión Española y reportero destacado en diversos conflictos armados y guerras, es el autor de la saga Las aventuras del capitán Alatriste, así como de numerosas novelas entre las que destacan "La tabla de Flandes", "El Club Dumas" y "La piel del tambor".'
        , 'arturoperezreverte.jpeg')
    ,  ('Megan Maxwell', 'Megan Maxwell (Nuremberg, Alemania, 26 de febrero de 1965) es una conocida escritora de literatura romántica de origen español, por parte de madre, y norteamericano, por parte de padre.

Tras más de doce años recibiendo negativas por parte de las editoriales, en el año 2009, Maxwell logra la publicación de su primera novela “Deseo Concedido”. Hasta el 2014, ha publicado cerca de una veintena de libros que, sin alejarse de la literatura romántica, alternan distintos subgéneros, como el chick lit, medieval, viajes en el tiempo o literatura erótica.'
        , 'meganmaxwell.jpg')
    ,  ('Antoine de Saint Exupéry', 'Antoine de Saint-Exupéry(Lyon-Marsella) fue
            un escritor y aviador francés, autor de "El principito"', 'saint_exupery.jpg')
    ,  ('Ken Follet', 'Ken Follett (Cardiff, Reino Unido, 5 de junio de 1949) es un autor galés mundialmente conocido por sus novelas históricas y de suspense.

        Tras licenciarse en filosofía en la University College of London, el joven Follet realiza un breve curso de periodismo con el que consigue un puesto como reportero en un pequeño diario de Cardiff, trabajo que le servirá como catapulta para entrar en el Evening Standard, en Londres.'
        , 'ken_follett.jpg')
    ,  ('Mario Vargas Llosa', 'Escritor y dramaturgo peruano, Mario Vargas Llosa es uno de los grandes autores contemporáneos en lengua española y uno de los más reconocidos autores de los últimos treinta años. Ganador de premios como el Cervantes o el Nobel de Literatura, Vargas Llosa también ha destacado como ensayista y autor de piezas teatrales. Nacido en una familia de clase media, Vargas Llosa pasó varios años de su infancia en Bolivia debido al divorcio de sus padres antes de volver a    Perú, donde estudiaría en varios centros, tanto religiosos como militares. Durante esta época comenzó a escribir, pese al rechazo de su padre a su carrera literaria, y colaboró con diarios mientras terminaba su primera pieza teatral,'
        , 'mario_vargas_llosa.jpg')
    ,  ('Mario Benedetti', 'Mario Benedetti (Paso de los Toros,  Uruguay, 14 de septiembre de 1920 - Montevideo, Uruguay, 17 de mayo de 2009) fue un escritor, poeta y dramaturgo uruguayo, integrante de la Generación del 45. Su prolífica producción literaria incluyó más de 80 libros, algunos de los cuales fueron traducidos a más de 20 idiomas. Su novela más conocida es “La tregua”. '
        , 'mario_benedetti.jpg')
    ,  ('Laura Gallego García', 'Laura Gallego García nació el 11 de octubre de 1977 en Quart de Poblet (Valencia). Su primera novela fué "Zodiaccía,un mundo diferente" y la escribió junto con su amiga Miriam a los once años. A los 21 años, cuando estaba estudiando Filología, escribió la novela "Finis Mundi", con la que obtuvo el primer premio en el concurso "Barco De Vapor". Su segundo premio en el concurso Barco De Vapor lo consiguió con su novela La leyenda del Rey Errante. Con la editorial SM también ha publicado "El Coleccionista de Relojes Extraordinarios" y bajo el sello Gran Angular publicó "Las Hijas de Tara".rnrnEs fundadora de la revista universitaria Náyade, repartida trimestralmente en la Facultad de Filología y fue codirectora de la misma desde 1997 a 2010.'
        , 'laura_gallego.jpg');


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
        , ('Juvenil no ficción')
        , ('Terror')
        , ('Manga')
        , ('Ficción');

-- Libros --
INSERT INTO libros ( titulo, isbn, anyo, sinopsis, url_compra, autor_id, genero_id, imagen)
VALUES ('El principito', '9788498381498', 1943, 'El principito habita un pequeñísimo
            asteroide, que comparte con una flor y empieza a experimentar la soledad.'
            , 'https://www.amazon.es/gp/product/8498381495/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 7, 13, '9788498381498.jpg')
    , ('Vuelo Nocturno', '9788466726399', 1931, 'El piloto Fabien afronta una violenta tormenta en el cielo de Argentina. En Buenos Aires, Ravière, su patrón, medita en su oficina. La esposa de Fabien se encuentra muy inquieta sobre el estado de su marido.
        Detrás de una pintura de la organización franco-venezolana Aeropostal, la obra trata de la problemática del héroe para quien toda acción revela lo absoluto. La fuerza del hombre heroico es de borrarse frente a este absoluto. Pero el hombre valora a la humanidad por los efectos de su acción. Frente a la solicitud, él asume este significado.
    '   , 'https://www.amazon.es/gp/product/846672639X/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
                , 7, 13, '9788466726399.jpg')
    , ('Deseos de felicidad', '9788421679579', 2014, 'Precioso miniálbum con las citas más hermosas de Antoine de Saint-Exupéry sobre los deseos de felicidad. Con ilustraciones originales del autor.'
                , 'https://www.amazon.es/gp/product/8421679570/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
                , 7, 2, '9788421679579.jpg')
    ,  ('El resplandor', '9788497593809', 1977, 'Tenía una deuda pendiente con Stephen King.
            Crecí rodeado de sus libros;It, Cementerio de animales, ...'
            , 'https://www.amazon.es/gp/product/9875668478/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 1, 19, '9788497593809.jpg')
    ,  ('IT', '9788497593793', 1980, 'En la relativamente tranquila ciudad de Derry habita, en las profundidades, un ser que despierta cada tres décadas para saciar su hambre. Un grupo de niños repletos de complejos, miedos e inseguridades forman una pandilla de marginados y consideran oportuno enfrentarse a It, que es como le llaman. It, sin embargo, tiene la capacidad de conocer los miedos de sus contrincantes y presentarse de diversas formas. En concreto, adora la forma de Pennywise, un payaso de apariencia muy tranquilizadora y amable, de esos que no te revientan la infancia con su aspecto amigable. Gracias, señor King.'
            , 'https://www.amazon.es/gp/product/8497593790/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 1, 21, '9788497593793.jpg')
    ,  ('Carrie', '9788497595698', 2013, '«Carrie es una adolescente que vive bajo la opresión y la locura de una madre fanáticamente religiosa que la mantiene prácticamente encerrada y alejada de la vida real. El temor de Carrie es que su madre la castigue en el cuarto oscuro donde, una vez dentro, tiene que rezar para que Dios le perdone sus pecados. Pero Carrie tiene un poder mental que su madre desconoce y un día lo pone en acción inconscientemente y descubre que es capaz de dar órdenes a las cosas materiales. Una lluvia de piedras es el principio de todo.»'
            , 'https://www.amazon.es/gp/product/8497595696/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 1, 21, '9788497595698.jpg')
    ,  ('Marina', '9788423687268', 1999, '«Óscar Drai se marchó huyendo de sus recuerdos, pensando ingenuamente que, si ponía suficiente distancia, las voces de su pasado se acallarían para siempre. Ahora ha regresado a su ciudad, Barcelona, para conjurar sus fantasmas y enfrentarse a su memoria. La macabra aventura que le marcó en su juventud, el terror y la locura rodearon, curiosamente, la más bella historia de amor.»'
            , 'https://www.amazon.es/gp/product/8423687260/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 2, 20, '9788423687268.jpg')
    ,  ('El juego del angel', '9788408081180', 2008, 'Óscar Drai se marchó huyendo de sus recuerdos, pensando ingenuamente que,
            si ponía suficiente distancia, las voces de su pasado se acallarían para siempre ...'
            , 'https://www.amazon.es/gp/product/8408081187/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 2, 4, '9788408081180.jpg')
    ,  ('El principe de la niebla', '9788408072805', 1993, '«El nuevo hogar de los Carver está rodeado de misterio. En él aún se respira el espíritu de Jacob, el hijo de los antiguos propietarios, que murió ahogado. Las extrañas circunstancias de esa muerte sólo empiezan a aclarar con la aparición de un diabólico personaje: el Príncipe de la Niebla, capaz de conceder cualquier deseo a una persona a un alto precio...»'
            , 'https://www.amazon.es/gp/product/8408072803/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 2, 20, '9788408072805.jpg')
    ,  ('La suma de los días', '9788401341915', 2007, 'Isabel Allende narra a su hija Paula
            todo lo que ha sucedido con la familia desde el momento en que ella murió. El lector vive, junto con la autora...'
            , 'https://www.amazon.es/gp/product/8401341914/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 3, 3, '9788401341915.jpg')
    ,  ('La casa de los espiritus', '9788483462034', 2014, '«Primera novela de Isabel Allende que nos narra la historia de una poderosa familia de terratenientes latinoamericanos. El depósito patriarca Esteban Trueba ha construido con mano de hierro un imperio privado que empieza a tambalearse a raíz del paso del tiempo y de un entorno social explosivo. Finalmente, la decadencia personal del patriarca arrastrará a los Trueba a una dolorosa desintegración. Atrapados en unas dramáticas relaciones familiares, los personajes de esta portentosa novela encarnan las tensiones sociales y espirituales de una época que abarca gran parte de este siglo.»'
            , 'https://www.amazon.es/gp/product/8483462036/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 3, 15, '9788483462034.jpg')
    ,  ('Juego de tronos (canción de hielo y fuego #1)', '9788496208964', 1996, 'Primer libro de la saga CANCIÓN DE HIELO Y FUEGO.
            «En un mundo donde las estaciones pueden durar decenios y donde las tierras del norte,
            más allá del Muro, ocultan seres míticos y temibles,...'
            , 'https://www.amazon.es/gp/product/8496208966/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 4, 8, '9788496208964.jpg')
    ,  ('Choque de reyes(canción de hielo y fuego #2)', '9788496208643', 1999, 'Segundo libro de la saga CANCIÓN DE HIELO Y FUEGO.

«Un cometa del color de la sangre hiende el cielo cargado de malos augurios. Y hay razones sobradas para pensar así: los Siete Reinos se ven sacudidos por las luchas intestinas entre los nobles por la sucesión al Trono de Hierro. En la otra orilla del océano, la princesa Daenerys Targaryen conduce a su pueblo de jinetes salvajes a través del desierto. Y en los páramos helados del Norte, más allá del Muro, un ejército implacable avanza impune hacia un territorio asolado por el caos y las guerras fraticidas.»'
            , 'https://www.amazon.es/gp/product/8496208648/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 4, 8, '9788496208643.jpg')
    ,  ('Tormenta de Espadas (canción de hielo y fuego #3)', '9788496208988', 2000, 'Tercer libro de la saga CANCIÓN DE HIELO Y FUEGO.

«Las huestes de los fugaces reyes de Poniente, descompuestas en hordas, asolan y esquilman una tierra castigada por la guerra e indefensa ante un invierno que se anuncia inusitadamente crudo. Las alianzas nacen y se desvanecen como volutas de humo bajo el viento helado del Norte. Ajena a las intrigas palaciegas, e ignorante del auténtico peligro en ciernes, la Guardia de la Noche se ve desbordada por los salvajes. Y al otro lado del mundo, Daenerys Targaryen intenta reclutar en las Ciudades Libres un ejército con el que desembarcar en su tierra.»'
            , 'https://www.amazon.es/gp/product/8496208966/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 4, 8, '9788496208988.jpg')
    ,  ('Festín de cuervos (canción de hielo y fuego #4)', '9788496208995', 2005, 'Cuarto libro de la saga CANCIÓN DE HIELO Y FUEGO.

«Las circunstancias han forzado una tregua en la guerra de los Cinco Reyes. Los intrigantes miembros de la Casa Lannister intentan consolidar su hegemonía en Poniente; la flota de las Islas del Hierro se congrega para la elección de un rey que restituya la gloria perdida del Trono de Piedramar, y en Dorne, el único de los Siete Reinos que permanece apartado del conflicto, el asesinato de la princesa Elia y de los herederos Targaryen todavía se recuerda con dolor y rabia. Entre tanto, Brienne de Tarth parte en busca de Sansa Stark en cumplimiento de una promesa, y Samwell Tarly regresa de las tierras inhóspitas de más allá del Muro acompañado de una mujer y un niño de pecho.»'
            , 'https://www.amazon.es/gp/product/8496208990/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 4, 8, '9788496208995.jpg')
    ,  ('Las ranas también se enamoran', '9788492929467', 2011, 'Marta Rodríguez es una joven y divertida madre
              soltera que conduce una Honda CBF 600. Trabaja en el taller de moda flamenca de Lola Herrera,...'
            , 'https://www.amazon.es/gp/product/8492929464/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 6, 13, '9788492929467.jpg')
    ,  ('Te esperaré toda mi vida', '9788415160601', 2008, '¿Qué ocurriría si una mujer de siglo XXI, como tú, viajara en el tiempo al siglo XVII? Averígualo sumergiéndote en las páginas de esta novela de la mano de Montse y sus dos amigas, Julia y Juana; unas españolas afincadas en Londres.
Una rifa, un premio, un viaje, una ciudad: Edimburgo. Tierra de leyendas y escoceses. Allí, en aquel momento, en aquel lugar, ocurrirá algo que cambiará para siempre la vida de la protagonista y sus amigas. ¿Quieres saber qué pasa? ¿Te apetece sonreír y divertirte?
¿Deseas enamorarte? Entonces, no tienes más remedio que abrir el libro y ponerte cómoda. ¡Disfrútalo!'
            , 'https://www.iberlibro.com/servlet/SearchResults?an=Megan%20Maxwell&sts=t&tn=Te%20esperar%E9%20toda%20mi%20vida.&clickid=x2tzcPUcOxyJRc7wUx0Mo3EzUklUl6zBiVMmWs0&cm_mmc=aff-_-ir-_-78079-_-77798&ref=imprad78079&afn_sr=impact'
            , 6, 19, '9788415160601.jpg')
    ,  ('El capitán alatriste', '9788466329149', 1996, '«No era el hombre más honesto ni el más piadoso, pero era un hombre valiente.»
Con estas palabras empieza El capitán Alatriste, la historia de un soldado veterano de los tercios de Flandes que malvive como espadachín a sueldo en el Madrid del siglo XVII. Sus aventuras peligrosas y apasionantes nos sumergen sin aliento en las intrigas de una España corrupta y en decadencia, las emboscadas en callejones oscuros entre el brillo de dos aceros, las tabernas donde Francisco de Quevedo compone sonetos entre pendencias y botellas de vino, o los corrales de comedias donde las representaciones de Lope de Vega terminan a cuchilladas.'
            , 'https://www.amazon.es/gp/product/8466329145/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 5, 9, '9788466329149.jpg')
    ,  ('Limpieza de sangre', '9788466312066', 1997, '«No era el hombre más honesto ni el más piadoso, pero era un hombre valiente.»
Con estas palabras empieza El capitán Alatriste, la historia de un soldado veterano de los tercios de Flandes que malvive como espadachín a sueldo en el Madrid del siglo XVII. Sus aventuras peligrosas y apasionantes nos sumergen sin aliento en las intrigas de una España corrupta y en decadencia, las emboscadas en callejones oscuros entre el brillo de dos aceros, las tabernas donde Francisco de Quevedo compone sonetos entre pendencias y botellas de vino, o los corrales de comedias donde las representaciones de Lope de Vega terminan a cuchilladas.'
            , 'https://www.amazon.es/gp/product/8466312064/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 5, 9, '9788466312066.jpg')
    ,  ('Los pilares de la tierra', '9788497592901', 1989, '«El gran maestro de la narrativa de acción y suspense Ken Follett nos transporta a la Edad Media, a un mundo fascinante de reyes, damas, caballeros, pugnas feudales, castillos y ciudades amuralladas. El amor y la muerte se entrecruzan vibrantemente en este magistral tapiz cuyo centro es la construcción de una catedral gótica. La historia se inicia con el ahorcamiento público de un inocente y finaliza con la humillación de un rey.»'
            , 'https://www.amazon.es/gp/product/8497592905/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 8, 9, '9788497592901.jpg')
    ,  ('El tercer gemelo', '9788497595377', 1996, 'Un científico joven se dedica a la indagación de diferencias de comportamiento y de personalidad en gemelos. Pero cuando descubre dos gemelos absolutamente idénticos nacidos de distintas madres, alguien tratará de detener la investigación a cualquier precio. ¿Se habrán realizado experimentos de clonación? ¿Y qué relación tiene todo esto con un candidato a la Casa Blanca?'
            , 'https://www.amazon.es/gp/product/8497595378/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 8, 6, '9788497595377.jpg')
    ,  ('La ciudad y los perros', '9788466309158', 2006, 'La ciudad y los perros no solamente es un ataque contra la crueldad ejercida a un grupo de jóvenes alumnos del Colegio Militar Leoncio Prado, sino también una crítica frontal al concepto erróneo de la virilidad, de sus funciones y de las consecuencias de una educación castrense malentendida.
Aunada a la brutalidad propia de la vida militar, a lo largo de las páginas de esta extraordinaria novela, la vehemencia y la pasión de la juventud se desbocan hasta llegar a una furia, una rabia y un fanatismo que anulan toda sensibilidad.
El libro más violento de Mario Vargas Llosa, traducido a más de treinta idiomas.'
            , 'https://www.amazon.es/gp/product/8466309152/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 9, 13, '9788466309158.jpg')
    ,  ('La fiesta del chivo', '9788466318709', 2006, '«En LA FIESTA DEL CHIVO asistimos a un doble retorno. Mientras Urania Cabral visita a su padre en Santo Domingo, volvemos a 1961, cuando la capital dominicana aún se llamaba Ciudad Trujillo. Allí un hombre que no suda tiraniza a tres millones de personas sin saber que se gesta una maquiavélica transición a la democracia. Vargas Llosa, un clásico contemporáneo, relata el fin de una era dando voz, entre otros personajes históricos, al impecable e implacable general Trujillo, apodado el Chivo, y al sosegado y hábil doctor Balaguer (sempiterno presidente de la República Dominicana). Con una precisión difícilmente superable, este peruano universal muestra que la política puede consistir en abrirse camino entre cadáveres, y que un ser inocente puede convertirse en un regalo truculento.»'
            , 'https://www.amazon.es/gp/product/8466318704/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 9, 13, '9788466318709.jpg')
    ,  ('La tregua', '9788420666884', 1979, '«La cotidianidad gris y rutinaria, marcada por la frustración y la ausencia de perspectivas de la clase media urbana, impregna las páginas de esta novela, que, adoptando la forma de un diario personal, relata un breve periodo de la vida de un empleado viudo, próximo a la jubilación, cuya existencia se divide entre la oficina, la casa, el café y una precaria vida familiar dominada por una difícil relación con unos hijos ya adultos. Una inesperada relación amorosa, que parece ofrecer al protagonista un horizonte de liberación y felicidad personal, queda trágicamente interrumpida y será tan sólo un inciso ?una tregua? en su lucha cotidiana contra el tedio, la soledad y el paso implacable del tiempo.»'
            , 'https://www.amazon.es/gp/product/8420666882/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 10, 13, '9788420666884.jpg')
    ,  ('El secreto de Xein', '9788490439562', 2018, 'Los caminos de Axlin y Xein vuelven a cruzarse, pero ambos parecen estar más alejados que nunca. Ella trabaja en la biblioteca y sigue recopilando información para completar su bestiario, mientras investiga lo que parece una presencia anormal de monstruos dentro de los muros de la Ciudadela. Por otro lado, al intentar ayudar a su amigo Dex con un problema personal se verá envuelta en un conflicto que implica a varias familias aristocráticas de la ciudad vieja.

Xein, por su parte, se ha convertido en uno más de los Guardianes que protegen a los habitantes de la Ciudadela de los monstruos que los acechan. Su lealtad a la Guardia lo obliga a mantener sus nuevos conocimientos ocultos para el resto de la gente y especialmente para Axlin, lo cual levantará un nuevo muro entre los dos.'
            , 'https://www.amazon.es/gp/product/8490439567/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 11, 8, '9788490439562.jpg')
    ,  ('Donde los arboles cantan', '9788467552249', 2012, 'Viana, la única hija del duque de Rocagrís, está prometida al joven Robian de Castelmar desde que ambos eran niños. Los dos se aman y se casarán en primavera. Sin embargo, durante los festejos del solsticio de invierno, un arisco montaraz advierte al rey de Nortia y sus caballeros de la amenaza de los bárbaros de las estepas... y tanto Robian como el duque se ven obligados a marchar a la guerra.
En tales circunstancias, una doncella como Viana no puede hacer otra cosa que esperar su regreso... y, tal vez, prestar atención a las leyendas que se cuentan sobre el Gran Bosque... el lugar donde los árboles cantan.'
            , 'https://www.amazon.es/gp/product/8467552247/ref=as_li_tf_tl?ie=UTF8&tag=entrel-21&linkCode=as2'
            , 11, 14, '9788467552249.jpg');
-- Comentarios --
INSERT INTO comentarios (texto, usuario_id, libro_id, comentario_id)
VALUES  ('Me ha encantado',1,1,null)
        ,  ('No me ha gustado mucho',1, 2, null)
        ,  ('Sin palabras',2, 3, null)
        ,  ('Sin palabras, pero además de verdad',2, 3, 3)
        ,  ('Desde luego que si compañero!',2, 3, 3)
        ,  ('Me ha encantado demasié!',2, 3, 1)
        ,  ('Me lo termińe ayer y me lo espero leer de nuevo.',5, 9, null)
        ,  ('Lo recomiendo para todo el que esté buscando un buen libro',14, 13, null)
        ,  ('Me ha enamorado este libro',12, 11, null)
        ,  ('Tampoco ha sido para tanto',5, 8, null)
        ,  ('Tampoco ha sido para ponerse asi',5, 8, null)
        ,  ('Nada mas que añadir',3, 4, null);

-- Libros_favs --
/* INSERT INTO libros_favs (usuario_id, libro_id)
VALUES  (1,1)
        ,  (1, 2)
        ,  (2, 2)
        ,  (3, 2); */

-- Autores_favs --
/* INSERT INTO autores_favs (usuario_id, autor_id)
VALUES  (1,1)
        ,  (1, 1)
        ,  (2, 1)
        ,  (3, 1); */

-- Usuarios_favs --
INSERT INTO users_favs (usuario_id, usuario_fav)
VALUES  (1,2)
        ,  (1, 3)
        ,  (2, 3)
        ,  (2, 4)
        ,  (1, 6)
        ,  (1, 7)
        ,  (1, 14)
        ,  (2, 11)
        ,  (2, 10)
        ,  (3, 1);

-- Estados --
INSERT INTO estados (usuario_id, estado, libro_id)
VALUES  (1, 'Qué pasada de libro, lo recomiendo al 100%!! "El principito".', 1)
        ,  (1, 'Volvería a leerme todos y cada uno de los libros de Carlos Ruiz Zafón.', null)
        ,  (2, 'Esperaba algo más de "Juego de Tronos".', 5)
        ,  (2, 'Esperaba algo más de este señor, me tenía muy bien acostumbrado.', 10)
        ,  (2, 'Lo volveré a leer sin ningún tipo de dudas', 15)
        ,  (3, 'Fabuloso, magnifico, increible...".', 11)
        ,  (3, 'No sé que libro empezar a leer...".', null)
        ,  (5, 'La verdad que es una de las mejores elecciones.', 12)
        ,  (5, 'No me ha gustado mucho el final, pero la lectura ha sido preciosa!.', 13)
        ,  (6, 'Mucha distracción con este libro".', 7)
        ,  (7, 'No me gustado este libro, no lo aconsejo.', 4)
        ,  (8, 'Aconsejo este libro al 1000%.', 14)
        ,  (10, 'No estoy teniendo tiempo ninguno para leer, con lo que me gustaria!!', null)
        ,  (12, 'Ahora despues de trabajar, un ratito leyendo! VAMOS!!', null)
        ,  (15, 'Mañana empiezo a leerlo!!!', 4);

-- Estados_favs --
INSERT INTO estados_favs (usuario_id, estado_id)
VALUES  (1, 3)
        ,  (1, 4)
        ,  (2, 1)
        ,  (3, 2);

-- Estados_lyb --
INSERT INTO estados_lyb (usuario_id, estado_id)
VALUES  (1, 4)
        ,  (1, 1)
        ,  (2, 4)
        ,  (3, 1);

-- estado_personal --
INSERT INTO estado_personal (usuario_id, contenido)
VALUES  (1, 'La lectura es mi distracción.'),
(2, 'Me encanta leer!'),
(3, 'Mi pasion!'),
(4, 'Seguidme y sigo!!'),
(5, 'Coleccionista!'),
(7, 'Lector de vocación!'),
(8, 'Me gusta esto!'),
(9, 'Mis libros son los mejores!'),
(11, 'Saco tiempo de donde sea!'),
(12, 'Poeta y escritor.'),
(14, 'Para y lee'),
        (15, 'Leer es saber');

-- libros_estados --
INSERT INTO libros_estados (estado)
VALUES  ('Leido')
      , ('Leyendo')
      , ('Me gustaría leerlo');

--  --
INSERT INTO seguimientos (usuario_id, libro_id, estado_id)
VALUES  (1, 1, 1)
    , (1, 2, 3)
    , (2, 1, 2);
