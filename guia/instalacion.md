# Instrucciones de instalación y despliegue

## En local

Para instalar la aplicación en local debemos tener al menos los siguientes requisitos:

* PHP 7.1.0 ó superior
* PostgreSQL
* Composer (descargar: https://getcomposer.org)

Una vez cumplas los requisitos deberás realizar los siguientes pasos para instalar la aplicación correctamente.

1. Deberemos clonar el repositorio de la aplicación web:

    ```
    ~ git clone https://github.com/jsmr95/libraryii.git
    ```

2. Desde la raíz del proyecto, instalar las dependencias del proyecto con este comando:

    ```
    ~ composer install
    ```

3. Una vez instalamos las dependencias, deberemos crear la base de datos e inyectar las tablas correspondientes:

    ```
    ~ db/create.sh
    ```

    ```
    ~ db/load.sh
    ```

4. Deberemos incluir las variables de entorno a nuestro proyecto, creamos una carpeta llamada *env* e introducimos nuestras variables:

    * SMTP_PASS: Clave generada con la contraseña de la aplicación.
    * IAM_KEY: Clave generada por el sevicio de Web Amazon Service (S3), para la autorización de subida de archivos a sus buckets.
    * IAM_SECRET: Clave generada por el sevicio de Web Amazon Service (S3), para la autorización de subida de archivos a sus buckets.

5. Una vez tengamos todo eso, solo falta iniciar el servidor local:

    ```
    ~ make serve
    ```

6. Una vez que se haya iniciado, tan solo tenemos que visitar:

    http://localhost:8000

## En la nube

Explicar.
