# Dificultades encontradas

Pues en mi caso tanto la máxima dificultad con la que me he encontrado y el elemento de innovación coinciden, que es el Amazon Web Service (S3).

El almacenamiento en la nube de Amazon. Yo creo que el problema radica en que hay demasiada información y muchas maneras de configurarlo, porque también dependiendo si lo haces desde Python, PHP, Java, Javascript, ... varía la forma de programarlo.

El problema principal fue a la hora de crear las credenciales necesarias para que desde tu aplicación web empareje con tu bucket en la nube de Amazon. Y luego por otro lado la manera de crear el Objeto Aws, al cual le tienes que pasar el objeto  (en mi caso una imagen de avatar para un usuario), y el bucket donde lo quieres añadir. Tuve que volver a cambiar las credenciales porque en un primer momento se crearon públicas y me llamaron desde el servicio de Amazon obligandome a eliminar estas credenciales y volviendome a crear otras privadas.
